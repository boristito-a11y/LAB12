<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nombre', 'pais_origen'];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
}