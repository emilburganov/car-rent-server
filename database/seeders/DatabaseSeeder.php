<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\CarClass;
use App\Models\CarModel;
use App\Models\Country;
use App\Models\Rent;
use App\Models\Role;
use App\Models\Salon;
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
        Role::query()->create([
            'name' => 'Client',
        ]);

        Role::query()->create([
            'name' => 'Admin',
        ]);

        Country::query()->create([
            'name' => 'Russia',
        ]);

        CarModel::query()->create([
            'name' => 'Lada',
            'country_id' => 1,
        ]);

        CarClass::query()->create([
           'name' => 'comfort',
        ]);

        User::factory(10)->create();

        User::query()->create([
            'login' => 'admin',
            'surname' => 'Бурганов',
            'name' => 'Эмиль',
            'patronymic' => 'Эдуардович',
            'phone' => '+7(999)999-99',
            'address' => 'Россия, Казань',
            'birthdate' => '23.03.2005',
            'role_id' => 2,
            'password' => Hash::make('12345678'),
        ]);

        Salon::query()->create([
           'name' => 'Kan Auto',
           'address' => 'Russia, Kazan',
           'user_id' => 1,
        ]);

        Car::factory(10)->create();
        Rent::factory(10)->create();
    }
}
