<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Property;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
            Review::create([
                'user_id' => $userIds[array_rand($userIds)],
                'property_id' => $propertyIds[array_rand($propertyIds)],
                'nota' => rand(1, 5),
                'comentario' => "Comentário de avaliação $i",
            ]);
        }
    }
}