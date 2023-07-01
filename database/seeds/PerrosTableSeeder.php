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
            'name' => 'Pepe',
            'size' => 'big',
            'hair_color' => 'negro',
            'img_url' => 'imagen1.jpg',
        ]);

        Perro::create([
            'race' => 'BullDog',
            'name' => 'Manolo',
            'size' => 'medium',
            'hair_color' => 'marrón',
            'img_url' => 'imagen2.jpg',
        ]);

        Perro::create([
            'race' => 'Caniche',
            'name' => 'Lolo',
            'size' => 'small',
            'hair_color' => 'gris',
            'img_url' => 'imagen3.jpg',
        ]);

        // Agrega más registros según tus necesidades
    }

}
