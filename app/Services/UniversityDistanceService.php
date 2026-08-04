<?php

namespace App\Services;

use App\Models\Property;
use App\Models\University;

class UniversityDistanceService
{
    /**
     * Maximum distance (meters) to associate a university with a property.
     */
    private const MAX_DISTANCE = 10000; // 10 km

    public function sync(Property $property): void
    {
        // If the property has no coordinates, remove existing relations.
        if (!$property->latitude || !$property->longitude) {
            $property->universities()->sync([]);

            return;
        }

        $syncData = [];

        $universities = University::query()
            ->active()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        foreach ($universities as $university) {

            $distance = $this->calculateDistance(
                $property->latitude,
                $property->longitude,
                $university->latitude,
                $university->longitude,
            );

            if ($distance <= self::MAX_DISTANCE) {
                $syncData[$university->id] = [
                    'distance' => $distance,
                ];
            }
        }

        $property->universities()->sync($syncData);
    }

    protected function calculateDistance(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2
    ): int {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lngFrom = deg2rad($lng1);
        $latTo   = deg2rad($lat2);
        $lngTo   = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $angle = 2 * asin(
                sqrt(
                    pow(sin($latDelta / 2), 2) +
                    cos($latFrom) *
                    cos($latTo) *
                    pow(sin($lngDelta / 2), 2)
                )
            );

        return (int) round($earthRadius * $angle);
    }
}
