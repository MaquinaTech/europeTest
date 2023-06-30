<?php

use Illuminate\Database\Seeder;
use App\Perro;


class PerrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perro::create([
            'race' => 'Labrador',
            'size' => 'Grande',
            'hair_color' => 'Negro',
            'img_url' => 'imagen1.jpg',
        ]);

        Perro::create([
            'race' => 'BullDog',
            'size' => 'Mediano',
            'hair_color' => 'Marrón',
            'img_url' => 'imagen2.jpg',
        ]);

        // Agrega más registros según tus necesidades
    }

}
