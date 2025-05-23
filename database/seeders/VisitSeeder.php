<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use App\Models\User;
use App\Models\Property;
use Carbon\Carbon;

class VisitSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            Visit::create([
                'user_id' => $userIds[array_rand($userIds)],
                'property_id' => $propertyIds[array_rand($propertyIds)],
                'data_hora' => Carbon::now()->addDays(rand(1, 30)),
                'status' => ['pendente', 'confirmado', 'cancelado'][array_rand(['pendente', 'confirmado', 'cancelado'])],
                'observacoes' => "Observação visita $i",
            ]);
        }
    }
}
