<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemexfolio extends Model
{
    use HasFactory;

    protected $table = 'pemexfolios';
    protected $primaryKey = 'idfolio';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
