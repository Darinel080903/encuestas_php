<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custodia extends Model
{
    use HasFactory;

    protected $table = 'custodias';
    protected $primaryKey = 'idcustodia';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
