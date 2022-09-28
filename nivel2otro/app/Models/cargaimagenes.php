<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cargaimagenes extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'cargaimagenes';

    protected $fillable = ['nombreimagen','imagen'];
}
