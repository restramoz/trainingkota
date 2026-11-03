<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Str;

/**
 * Training Kota adapter for the Devtyeng "scheme" (service catalog) concept.
 *
 * It exposes the existing Service catalog through the same surface that the
 * Devtyeng article generation engine expects (`all()` and `find()`), so the
 * OllamaService can reuse the proven prompt construction without changing the
 * Training Kota business data.
 */
class SchemeService
{
    /**
     * Return the full service catalog keyed by slug.
     *
     * @return array<string, array<string, mixed>>
     */
    public function all(): array
    {
        try {
            $services = Service::orderBy('name')->get();
        } catch (\Throwable $e) {
            return [];
        }

        $result = [];
        foreach ($services as $service) {
            $result[$service->slug] = $this->adapt($service);
        }

        return $result;
    }

    /**
     * Resolve a service by its slug.
     *
     * @return array<string, mixed>|null
     */
    public function find(?string $slug): ?array
    {
        $slug = trim((string) $slug);
        if ($slug === '') {
            return null;
        }

        try {
            $service = Service::where('slug', $slug)->first();
        } catch (\Throwable $e) {
            return null;
        }

        if (! $service) {
            return null;
        }

        return $this->adapt($service);
    }

    /**
     * Adapt a Service model into the Devtyeng "scheme" shape.
     *
     * @return array<string, mixed>
     */
    protected function adapt(Service $service): array
    {
        $units = [];
        foreach (is_array($service->syllabus) ? $service->syllabus : [] as $item) {
            $units[] = ['code' => '', 'name' => (string) $item];
        }

        if ($service->duration) {
            $units[] = ['code' => '', 'name' => 'Durasi: '.$service->duration];
        }

        return [
            'title' => $service->name,
            'category' => $service->category,
            'description' => $service->description,
            'units' => $units,
            'slug' => $service->slug,
        ];
    }
}
