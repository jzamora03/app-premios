<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $table = 'prizes';

    protected $fillable = ['nombre', 'descripcion', 'fecha_creacion'];

    protected $casts = [
        'fecha_creacion' => 'date', // Convertir fecha_creacion en un objeto de fecha
    ];


    public function participants()
{
    return $this->hasMany(Participant::class);
}


}
