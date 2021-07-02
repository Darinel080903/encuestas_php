<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoimg extends Model
{
    use HasFactory;

    protected $table = 'autosimgs';
    protected $primaryKey = 'idimg';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
