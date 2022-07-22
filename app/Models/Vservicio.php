<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vservicio extends Model
{
    use HasFactory;

    protected $table = 'vservicios';
    protected $primaryKey = 'idservicio';
    //By CIRG para deshabilitar los campos created_at y updated_at
    public $timestamps = false;
}
