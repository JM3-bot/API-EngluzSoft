<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyPhoto;
use App\Models\Property;

class PropertyPhotoSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();

        foreach ($properties as $property) {
            for ($i = 0; $i < rand(1, 4); $i++) {
                PropertyPhoto::create([
                    'property_id' => $property->id,
                    'path' => "property_photos/foto_{$property->id}_{$i}.jpg",
                ]);
            }
        }
    }
}
