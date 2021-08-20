<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vauto extends Model
{
    use HasFactory;

    protected $table = 'vautos';
    protected $primaryKey = 'idauto';
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

    public function scopeActivo($query, $activo)
    {
        if($activo != "")
        {
            return $query->where('activo', $activo);
        }
    }
    
    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('numero', 'like', "%$busqueda%")->orWhere('fabrica', 'like', "%$busqueda%")->orWhere('tipo', 'like', "%$busqueda%")->orWhere('modelo', 'like', "%$busqueda%")->orWhere('descripcion', 'like', "%$busqueda%");
        }
    }
}
