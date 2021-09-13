<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    protected $table = 'detalles';
    protected $primaryKey = 'iddetalle';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
