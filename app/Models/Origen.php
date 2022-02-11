<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origen extends Model
{
    use HasFactory;

    protected $table = 'origenes';
    protected $primaryKey = 'idorigen';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
    
}
