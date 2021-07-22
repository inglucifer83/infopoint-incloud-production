<?php

namespace App\Models;

use App\Models\Lingue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LingueUser extends Model
{
    protected $table = "lingueuser"; 
    protected $primaryKey = "id";

    public function getLanguageDuplicate($userid, $linguaid)
    {
        $linguauserex = LingueUser::where('lingua_id', $linguaid)->andWhere('user_id', $userid);
        dd($linguauserex);
    }

    use HasFactory;
}
