<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    use HasFactory;

    protected $table = 'folios';
    protected $primaryKey = 'idfolio';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
