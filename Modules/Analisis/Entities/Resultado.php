<?php

namespace Modules\Analisis\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $table = 'analisis__resultados';
    public $translatedAttributes = [];
    protected $fillable = [];

    public function determinacion(){
      return $this->belongsTo('Modules\Analisis\Entities\Determinacion');
    }
}
