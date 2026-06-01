<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = ['modelo', 'anio', 'precio', 'kilometraje', 'stock', 'foto', 'marca_id'];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function estadoStock(): string
    {
        if ($this->stock <= 0)  return 'agotado';
        if ($this->stock <= 3)  return 'bajo';
        if ($this->stock <= 7)  return 'medio';
        return 'disponible';
    }

    public function badgeStock(): string
    {
        return match($this->estadoStock()) {
            'agotado'    => '<span class="badge bg-danger">Sin stock</span>',
            'bajo'       => '<span class="badge bg-danger">Quedan ' . $this->stock . ' unidades</span>',
            'medio'      => '<span class="badge bg-warning text-dark">Stock medio (' . $this->stock . ')</span>',
            'disponible' => '<span class="badge bg-success">En stock (' . $this->stock . ')</span>',
        };
    }
}