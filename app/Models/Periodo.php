<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = ['gestion_id', 'nombre'];

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }
}