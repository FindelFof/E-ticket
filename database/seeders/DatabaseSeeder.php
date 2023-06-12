<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $eventNames = [
            'Concert de DJ Arafat',
            'Spectacle de Magic System',
            'Show de Serge Beynaud',
            'Concert de Kerozen',
            'Festival des voix d\'Anges',
            'Concert de Debordo Leekunfa',
            'Spectacle de Tiken Jah Fakoly',
            'Show de Meiway',
            'Concert de Ariel Sheney',
            'Festival des danses traditionnelles',
        ];

        $cities = ['Abidjan', 'Bouaké','Korhogo'];
        $locations = ['Palais de la Culture', 'Hôtel Ivoire','Salle des Mairies'];

        for ($i = 0; $i < 15; $i++) {
            $name = $eventNames[array_rand($eventNames)];
            $date = $this->generateRandomDate();
            $city = $cities[array_rand($cities)];
            $location = $locations[array_rand($locations)];
            $price = mt_rand(1000, 5000);

            Event::create([
                'name' => $name,
                'date' => $date,
                'city' => $city,
                'location' => $location,
                'price' => $price,
            ]);
        }
        User::create([
            'name' => "Findel Fofana",
            'email'=> "findel.fofana@user.ci",
            'password' => Hash::make("password1234"),
        ]);
    }

    private function generateRandomDate(): string
    {
        $startDate = strtotime('16 May 2023');
        $endDate = strtotime('15 June 2024');

        $randomTimestamp = mt_rand($startDate, $endDate);

        return date('Y-m-d', $randomTimestamp);
    }
}
