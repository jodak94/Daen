<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $table = 'analisis__seccions';
    public $translatedAttributes = [];
    protected $fillable = ['titulo', 'orden', 'salto_pagina', 'background'];

    public function subsecciones(){
      return $this->hasMany('Modules\Analisis\Entities\Subseccion');
    }
}
