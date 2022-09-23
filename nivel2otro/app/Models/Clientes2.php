<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes2 extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'clientes2s';

    protected $fillable = ['nombre','apellidos','direccion','email'];
	
}
