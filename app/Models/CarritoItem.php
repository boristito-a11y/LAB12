<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $fillable = ['user_id', 'vehiculo_id', 'cantidad'];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}