<?php

namespace Database\Seeders;

use App\Models\ParameterGlobal;
use Illuminate\Database\Seeder;

class ParameterGlobalSeeder extends Seeder
{
    public function run(): void
    {
        $parameters = [
            [
                'name' => 'MAIL_USERNAME',
                'value' => config(
                    'mail.mailers.smtp.username'
                ),
                'is_public' => false,
            ],

            [
                'name' => 'MAIL_PASSWORD',
                'value' => config(
                    'mail.mailers.smtp.password'
                ),
                'is_public' => false,
            ],

            [
                'name' => 'MAIL_FROM_ADDRESS',
                'value' => config(
                    'mail.from.address'
                ),
                'is_public' => false,
            ],

            [
                'name' => 'MIN_BOOKING_JAM',
                'value' => '6',
                'is_public' => true,
            ]
        ];

        foreach ($parameters as $parameter) {

            /*
             * firstOrCreate sengaja digunakan.
             *
             * Seeder berikutnya tidak menimpa
             * value yang sudah diedit admin.
             */

            ParameterGlobal::firstOrCreate(
                [
                    'name' => $parameter['name'],
                ],
                [
                    'value' => $parameter['value'],
                    'is_public' => $parameter['is_public'],
                ]
            );
        }
    }
}
