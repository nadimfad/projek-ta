<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AcademicSubmissionService
{
    public function search(string $name): array
    {
        $url = config('services.academic_submission.url');
        $apiKey = config('services.academic_submission.key');
        $startTime = config('services.academic_submission.start_time');
        $endTime = config('services.academic_submission.end_time')
            ?: now()->endOfDay()->format('Y-m-d H:i:s');

        if (blank($url) || blank($apiKey)) {
            throw new \RuntimeException('Koneksi data akademik belum dikonfigurasi. Hubungi administrator.');
        }

        try {
            $response = Http::acceptJson()
                ->withHeaders(['x-api-key' => $apiKey])
                ->timeout(12)
                ->retry(1, 250, throw: false)
                ->get($url, [
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'name' => $name,
                ]);
        } catch (ConnectionException) {
            throw new \RuntimeException('Server data akademik sedang tidak dapat dihubungi.');
        }

        if (! $response->successful()) {
            throw new \RuntimeException($this->responseErrorMessage($response->status()));
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new \RuntimeException('Format respons data akademik tidak valid.');
        }

        return collect($this->extractRecords($payload))
            ->filter(fn ($record) => is_array($record))
            ->flatMap(fn (array $record) => $this->normalizeStudentRecord($record))
            ->filter(fn (array $record) => filled($record['nama_mahasiswa']) || filled($record['nim_mahasiswa']))
            ->take(10)
            ->values()
            ->all();
    }

    private function extractRecords(array $payload): array
    {
        $candidates = [
            data_get($payload, 'data.data'),
            data_get($payload, 'data'),
            data_get($payload, 'results'),
            data_get($payload, 'submissions'),
            $payload,
        ];

        foreach ($candidates as $candidate) {
            if (is_array($candidate) && array_is_list($candidate)) {
                return $candidate;
            }
        }

        return [];
    }

    private function normalizeStudentRecord(array $student): array
    {
        $studentValues = $this->flatten($student);
        $submissions = data_get($student, 'submissions', []);

        if (! is_array($submissions) || ! array_is_list($submissions)) {
            return [$this->normalizeSubmission($studentValues, [])];
        }

        return collect($submissions)
            ->filter(fn ($submission) => is_array($submission))
            ->map(fn (array $submission) => $this->normalizeSubmission($studentValues, $submission))
            ->all();
    }

    private function normalizeSubmission(array $studentValues, array $submission): array
    {
        $submissionValues = $this->flatten($submission);
        $email = $this->valueFor($studentValues, ['email', 'mahasiswa.email', 'student.email']);
        $verificators = collect(data_get($submission, 'verificators', []))
            ->filter(fn ($verificator) => is_array($verificator));

        $pembimbing = $this->lecturersByRole($verificators, 'pembimbing');
        $penguji = $this->lecturersByRole($verificators, 'penguji');

        return [
            'nama_mahasiswa' => $this->valueFor($studentValues, [
                'nama_mahasiswa', 'mahasiswa.nama', 'student.name', 'student_name', 'name',
            ]),
            'nim_mahasiswa' => $this->valueFor($studentValues, [
                'nim_mahasiswa', 'mahasiswa.nim', 'student.nim', 'nim', 'student_nim',
            ]) ?? $this->nimFromEmail($email),
            'dosen_pembimbing_1' => $pembimbing[0] ?? null,
            'dosen_pembimbing_2' => $pembimbing[1] ?? null,
            'dosen_penguji_1' => $penguji[0] ?? null,
            'dosen_penguji_2' => $penguji[1] ?? null,
            'jenis_kegiatan' => $this->mapActivity($this->valueFor($submissionValues, [
                'jenis_kegiatan', 'jenis_seminar', 'kegiatan', 'activity', 'seminar_type', 'type',
            ])),
        ];
    }

    private function lecturersByRole($verificators, string $role): array
    {
        return $verificators
            ->filter(function (array $verificator) use ($role) {
                return Str::lower((string) ($verificator['role_type'] ?? '')) === $role;
            })
            ->map(function (array $verificator) {
                return $verificator['nama_verificator'] ?? null;
            })
            ->filter(fn ($name) => filled($name))
            ->values()
            ->take(2)
            ->all();
    }

    private function nimFromEmail(?string $email): ?string
    {
        if (blank($email)) {
            return null;
        }

        $identifier = Str::before($email, '@');

        return preg_match('/^[a-z]\d{6,}$/i', $identifier) ? $identifier : null;
    }

    private function responseErrorMessage(int $status): string
    {
        return match ($status) {
            401, 403 => 'Akses ke data akademik ditolak. Hubungi administrator.',
            429 => 'Pencarian data akademik terlalu sering. Tunggu sekitar satu menit, lalu coba lagi.',
            default => 'Server data akademik sedang bermasalah. Silakan coba lagi beberapa saat.',
        };
    }

    private function flatten(array $values, string $prefix = ''): array
    {
        $flattened = [];

        foreach ($values as $key => $value) {
            $normalizedKey = is_int($key) ? (string) $key : Str::snake((string) $key);
            $path = $prefix === '' ? $normalizedKey : $prefix.'.'.$normalizedKey;

            if (is_array($value)) {
                $flattened += $this->flatten($value, $path);

                continue;
            }

            if (is_scalar($value) || $value === null) {
                $flattened[$path] = $value;
            }
        }

        return $flattened;
    }

    private function valueFor(array $values, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = $values[$key] ?? null;

            if (is_scalar($value) && filled((string) $value)) {
                return trim((string) $value);
            }
        }

        return null;
    }

    private function mapActivity(?string $activity): ?string
    {
        if (blank($activity)) {
            return null;
        }

        $normalized = Str::lower($activity);

        return match (true) {
            Str::contains($normalized, 'proposal') => 'Seminar Proposal',
            Str::contains($normalized, ['hasil', 'tertutup']) => 'Seminar Hasil/Sidang Tertutup',
            Str::contains($normalized, ['akhir', 'terbuka']) => 'Seminar Akhir/Sidang Terbuka',
            default => null,
        };
    }
}
