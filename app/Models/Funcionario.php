<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';
    protected $primaryKey = 'idfuncionario';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;

    public function scopeBusqueda($query, $busqueda)
    {
        if($busqueda)
        {
            return $query->where('nombre', 'like', "%$busqueda%")->orWhere('paterno', 'like', "%$busqueda%")->orWhere('materno', 'like', "%$busqueda%");
        }
    }
}
