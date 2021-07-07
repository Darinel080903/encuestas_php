<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'idfactura';
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
            return $query->where('numero', 'like', "%$busqueda%")->orwhere('proveedor', 'like', "%$busqueda%")->orwhere('monto', 'like', "%$busqueda%");
        }
    }
}