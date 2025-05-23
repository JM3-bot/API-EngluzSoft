<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyView;
use App\Models\User;
use App\Models\Property;

class PropertyViewSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            PropertyView::create([
                'property_id' => $propertyIds[array_rand($propertyIds)],
                'user_id' => rand(0,1) ? $userIds[array_rand($userIds)] : null,
                'ip_address' => '127.0.0.' . rand(1, 255),
            ]);
        }
    }
}
