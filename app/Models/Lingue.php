<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lingue extends Model
{
    protected $table = "lingue"; 
    protected $primaryKey = "id";

    use HasFactory;
}
