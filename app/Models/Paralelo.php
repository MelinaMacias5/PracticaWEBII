<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;

class Paralelo extends Model
{    use HasFactory;
    //habilitar el guardado
    //mostrar como esta estructuradala tabla
     protected$fillable = ['nombre'];
    //enseñar como relacionarle con las otras tablas

    public function estudiantes(){
        return $this->hasMany(Estudiante::class);
    }
}
