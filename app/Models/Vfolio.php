<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vfolio extends Model
{
    use HasFactory;

    protected $table = 'vfolios';
    protected $primaryKey = 'idfolio';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}