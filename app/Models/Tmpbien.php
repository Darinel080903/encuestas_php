<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmpbien extends Model
{
    use HasFactory;

    protected $table = 'tmpbienes';
    protected $primaryKey = 'idtmpbien';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
