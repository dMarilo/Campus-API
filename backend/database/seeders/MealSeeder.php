<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use Carbon\Carbon;

class MealSeeder extends Seeder
{
    public function run()
    {
        $mealOptions = [
            'breakfast' => [
                ['eggs', 'toast', 'coffee'],
                ['porridge', 'milk', 'banana'],
                ['pancakes', 'syrup', 'tea'],
                ['croissant', 'butter', 'jam']
            ],
            'lunch' => [
                ['chicken', 'rice', 'salad'],
                ['pasta', 'meatballs', 'bread'],
                ['fish', 'potatoes', 'vegetables'],
                ['burger', 'fries', 'cola']
            ],
            'dinner' => [
                ['soup', 'bread'],
                ['pizza', 'salad'],
                ['stew', 'mashed potatoes'],
                ['sandwich', 'yogurt']
            ],
        ];

        // Seed meals for the last 7 days + today
        for ($i = 0; $i < 8; $i++) {
            $date = Carbon::today()->subDays($i);

            foreach (['breakfast', 'lunch', 'dinner'] as $mealType) {
                Meal::create([
                    'date' => $date,
                    'type' => $mealType,
                    'items' => $mealOptions[$mealType][array_rand($mealOptions[$mealType])],
                ]);
            }
        }
    }
}

