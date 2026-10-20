<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Jemputan Bandara',
                'slug' => 'jemputan-bandara',
                'icon' => 'faPlaneDeparture',
                'status' => true,
            ],
            [
                'name' => 'Terlaris',
                'slug' => 'terlaris',
                'icon' => 'faCalendarDays',
                'status' => true,
            ],
            [
                'name' => 'Paket Hemat',
                'slug' => 'paket-hemat',
                'icon' => 'faTags',
                'status' => true,
            ],
            [
                'name' => 'Include Hotel',
                'slug' => 'include-hotel',
                'icon' => 'faHotel',
                'status' => true,
            ],
            [
                'name' => 'Hiking',
                'slug' => 'hiking',
                'icon' => 'faHiking',
                'status' => true,
            ],
            [
                'name' => 'Rental Mobil',
                'slug' => 'rental-mobil',
                'icon' => 'faCar',
                'status' => true,
            ],
            [
                'name' => 'Wisata Harian',
                'slug' => 'paket-wisata-harian',
                'icon' => 'faSuitcase',
                'status' => true,
            ],
            [
                'name' => 'Korporasi',
                'slug' => 'korporasi',
                'icon' => 'faGroupArrowsRotate',
                'status' => true,
            ],

        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(
                [
                    'slug' => $tag['slug'],
                ],
                $tag
            );
        }
    }
}
