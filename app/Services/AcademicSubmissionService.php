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

        if (blank($url) || blank($apiKey)) {
            throw new \RuntimeException('Koneksi data akademik belum dikonfigurasi. Hubungi administrator.');
        }

        try {
            $response = Http::acceptJson()
                ->withHeaders(['x-api-key' => $apiKey])
                ->timeout(12)
                ->retry(1, 250, throw: false)
                ->get($url, [
                    'start_time' => '',
                    'end_time' => '',
                    'name' => $name,
                ]);
        } catch (ConnectionException) {
            throw new \RuntimeException('Server data akademik sedang tidak dapat dihubungi.');
        }

        if (! $response->successful()) {
            throw new \RuntimeException('Server data akademik sedang bermasalah. Silakan coba lagi beberapa saat.');
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new \RuntimeException('Format respons data akademik tidak valid.');
        }

        return collect($this->extractRecords($payload))
            ->filter(fn ($record) => is_array($record))
            ->map(fn (array $record) => $this->normalizeRecord($record))
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

    private function normalizeRecord(array $record): array
    {
        $values = $this->flatten($record);

        return [
            'nama_mahasiswa' => $this->valueFor($values, [
                'nama_mahasiswa', 'mahasiswa.nama', 'student.name', 'student_name', 'name',
            ]),
            'nim_mahasiswa' => $this->valueFor($values, [
                'nim_mahasiswa', 'mahasiswa.nim', 'student.nim', 'nim', 'student_nim',
            ]),
            'dosen_pembimbing_1' => $this->valueFor($values, [
                'dosen_pembimbing_1', 'pembimbing_1', 'pembimbing1', 'pembimbing.0.nama', 'advisor_1', 'supervisor_1',
            ]),
            'dosen_pembimbing_2' => $this->valueFor($values, [
                'dosen_pembimbing_2', 'pembimbing_2', 'pembimbing2', 'pembimbing.1.nama', 'advisor_2', 'supervisor_2',
            ]),
            'dosen_penguji_1' => $this->valueFor($values, [
                'dosen_penguji_1', 'penguji_1', 'penguji1', 'penguji.0.nama', 'examiner_1',
            ]),
            'dosen_penguji_2' => $this->valueFor($values, [
                'dosen_penguji_2', 'penguji_2', 'penguji2', 'penguji.1.nama', 'examiner_2',
            ]),
            'jenis_kegiatan' => $this->mapActivity($this->valueFor($values, [
                'jenis_kegiatan', 'jenis_seminar', 'kegiatan', 'activity', 'seminar_type', 'type',
            ])),
        ];
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
