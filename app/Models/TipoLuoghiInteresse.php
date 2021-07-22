<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLuoghiInteresse extends Model
{
    protected $table = "tipoluoghiinteresse"; 
    protected $primaryKey = "id";
    
    use HasFactory;
}
