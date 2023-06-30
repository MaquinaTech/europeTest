<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perro extends Model
{
    protected $table = 'perros';

    protected $fillable = [
        'race',
        'size',
        'hair_color',
        'img_url',
    ];
}
