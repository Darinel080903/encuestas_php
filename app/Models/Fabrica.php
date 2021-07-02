<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabrica extends Model
{
    use HasFactory;

    protected $table = 'fabricas';
    protected $primaryKey = 'idfabrica';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('fabrica', 'like', "%$busqueda%");
        }
    }
}
