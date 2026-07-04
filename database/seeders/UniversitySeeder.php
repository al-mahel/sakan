<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $universities = [
            ['name' => 'جامعة القاهرة',     'city' => 'القاهرة'],
            ['name' => 'جامعة عين شمس',     'city' => 'القاهرة'],
            ['name' => 'جامعة الأزهر',      'city' => 'القاهرة'],
            ['name' => 'جامعة حلوان',       'city' => 'القاهرة'],
            ['name' => 'جامعة الإسكندرية',  'city' => 'الإسكندرية'],
            ['name' => 'جامعة أسيوط',       'city' => 'أسيوط'],
            ['name' => 'جامعة المنصورة',    'city' => 'المنصورة'],
            ['name' => 'جامعة طنطا',        'city' => 'طنطا'],
            ['name' => 'جامعة سوهاج',       'city' => 'سوهاج'],
            ['name' => 'جامعة المنيا',      'city' => 'المنيا'],
            ['name' => 'جامعة الفيوم',      'city' => 'الفيوم'],
            ['name' => 'جامعة قنا',         'city' => 'قنا'],
            ['name' => 'جامعة الزقازيق',    'city' => 'الزقازيق'],
            ['name' => 'جامعة بنها',        'city' => 'بنها'],
            ['name' => 'جامعة قناة السويس', 'city' => 'الإسماعيلية'],
        ];

        foreach ($universities as $index => $uni) {
            University::firstOrCreate(
                ['name' => $uni['name']],
                [
                    'slug'      => Str::slug($uni['name']) ?: 'university-' . $uni['order'],
                    'city'      => $uni['city'],
                    'order'     => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ تم إنشاء ' . count($universities) . ' جامعة بنجاح');
    }
}
