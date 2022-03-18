<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vvale extends Model
{
    use HasFactory;

    protected $table = 'vvales';
    protected $primaryKey = 'idvale';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
    
    public function scopeUsuario($query, $usuario)
    {
        if($usuario)
        {
            return $query->where('fkusuario', '=', $usuario);
        }
    }

    public function scopeEjercicio($query, $ejercicio)
    {
        if($ejercicio)
        {
            return $query->where('ejercicio', '=', $ejercicio);
        }
    }

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
            return $query->where('numero', 'like', "%$busqueda%")->orwhere('monto', 'like', "%$busqueda%")->orwhere('observacion', 'like', "%$busqueda%")->orwhere('facturas', 'like', "%$busqueda%");
        }
    }
}
