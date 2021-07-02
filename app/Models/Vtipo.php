<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vtipo extends Model
{
    use HasFactory;

    protected $table = 'vtipos';
    protected $primaryKey = 'idtipo';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('tipo', 'like', "%$busqueda%");
        }
    }
}
