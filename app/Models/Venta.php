<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['vendedor_id', 'fecha_venta', 'monto'];

    protected $casts = [
        'fecha_venta' => 'date',
        'monto' => 'float',
    ];

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }
}
