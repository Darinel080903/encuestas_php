<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vresguardo extends Model
{
    use HasFactory;

    protected $table = 'vresguardos';
    //protected $primaryKey = 'id';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('patrimonio', 'like', "%$busqueda%");
        }
    }
}