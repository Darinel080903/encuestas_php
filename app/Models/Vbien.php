<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vbien extends Model
{
    use HasFactory;

    protected $table = 'vbienes';
    protected $primaryKey = 'idbien';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        {
            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
            return $query->where('fecha', '=', $fechaformat);
        }
    }

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('articulo', 'like', "%$busqueda%")->orWhere('marca', 'like', "%$busqueda%")->orWhere('patrimonio', 'like', "%$busqueda%")->orWhere('funcionario', 'like', "%$busqueda%");
        }
    }
}
