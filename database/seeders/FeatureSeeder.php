<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        $features = ['Piscina', 'Garagem', 'Varanda', 'Churrasqueira', 'Academia'];

        foreach ($features as $nome) {
            Feature::create(['nome' => $nome]);
        }
    }
}
