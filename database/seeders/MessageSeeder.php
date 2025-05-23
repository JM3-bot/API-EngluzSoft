<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\Property;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $propertyIds = Property::pluck('id')->toArray();

        for ($i = 0; $i < 30; $i++) {
            $sender = $userIds[array_rand($userIds)];
            $receiver = $userIds[array_rand($userIds)];
            while ($receiver == $sender) {
                $receiver = $userIds[array_rand($userIds)];
            }

            Message::create([
                'sender_id' => $sender,
                'receiver_id' => $receiver,
                'property_id' => $propertyIds[array_rand($propertyIds)],
                'conteudo' => "Mensagem exemplo $i",
                'lido' => rand(0, 1),
            ]);
        }
    }
}
