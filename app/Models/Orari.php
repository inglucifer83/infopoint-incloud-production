<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orari extends Model
{
    protected $table = "orari";
    protected $primaryKey = "id";

    use HasFactory;
}
