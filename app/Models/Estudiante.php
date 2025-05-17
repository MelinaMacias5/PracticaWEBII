<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    //
    use HasFactory;
    protected $fillable = ['nombre','cedula','correo','paralelo_id'];
    public function paralelo(){
        return $this->belongsTo(Paralelo::class);
    }
}
