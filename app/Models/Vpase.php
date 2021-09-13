<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vpase extends Model
{
    use HasFactory;

    protected $table = 'vpases';
    protected $primaryKey = 'idpase';
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

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('solicita', 'like', "%$busqueda%");
        }
    }
}
