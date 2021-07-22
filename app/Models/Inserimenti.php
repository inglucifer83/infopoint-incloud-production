<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inserimenti extends Model
{
    protected $table = "inserimenti"; 
    protected $primaryKey = "id";
    
    use HasFactory;
}
