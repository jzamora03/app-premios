<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    public $timestamps = true; // Activar timestamps

    protected $fillable = [
        'nombre', 'apellido', 'cedula', 'departamento', 'ciudad', 'celular', 'correo_electronico', 'habeas_data', 'premio_id'
    ];

    public function prize()
{
    return $this->belongsTo(Prize::class);
}

}
