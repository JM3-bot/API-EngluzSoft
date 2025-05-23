<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Property;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        foreach ($userIds as $userId) {
            $favIds = array_rand(array_flip($propertyIds), rand(1, 5));

            foreach ((array)$favIds as $propertyId) {
                Favorite::firstOrCreate([
                    'user_id' => $userId,
                    'property_id' => $propertyId,
                ]);
            }
        }
    }
}
