<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vpemexvale extends Model
{
    use HasFactory;

    protected $table = 'vpemexvales';
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

    public function scopeFecha($query, $fecha)
    {
        if($fecha)
        {
            $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
            return $query->where('fecha', '=', $fechaformat);
        }
    }

    public function scopeComprobacion($query, $comprobacion)
    {
        if($comprobacion != '')
        {
            return $query->where('activo', $comprobacion);
        }
    }

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('placa', 'like', "%$busqueda%")->orwhere('numero', 'like', "%$busqueda%")->orwhere('nombrecompleto', 'like', "%$busqueda%")->orwhere('monto', 'like', "%$busqueda%")->orwhere('observacion', 'like', "%$busqueda%")->orwhere('recibe', 'like', "%$busqueda%");
        }
    }
}