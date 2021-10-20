<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vhistorico extends Model
{
    use HasFactory;

    protected $table = 'vhistoricos';
    protected $primaryKey = 'idhistorico';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
