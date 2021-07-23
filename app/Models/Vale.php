<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vale extends Model
{
    use HasFactory;

    protected $table = 'vales';
    protected $primaryKey = 'idvale';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
