<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Room;
use Illuminate\Database\Seeder;
use App\Services\UniversityDistanceService;
class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $service = app(UniversityDistanceService::class);

        Property::factory(30)
            ->create()
            ->each(function (Property $property) use ($service) {

                $roomCount = match ($property->type) {
                    'غرفة'      => 1,
                    'سرير'      => 1,
                    'ستوديو'    => 1,
                    'شقة'       => rand(2, 3),
                    'دوبلكس'    => rand(3, 4),
                    'بنتهاوس'   => rand(3, 4),
                    'فيلا'      => rand(3, 5),
                    'تاون هاوس' => rand(3, 4),
                    'توين هاوس' => rand(3, 4),
                    'شاليه'     => rand(2, 3),
                    default     => rand(1, 3),
                };

                Room::factory($roomCount)->create([
                    'property_id' => $property->id,
                ]);

                $service->sync($property);
            });

        $this->command->info('✅ تم إنشاء 30 عقار مع غرفهم بنجاح');
    }
}
