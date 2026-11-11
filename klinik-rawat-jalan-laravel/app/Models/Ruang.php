<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;

    protected $table = 'ruangs';
    protected $guarded = ['id'];

    public function alatMedis()
    {
        return $this->hasMany(AlatMedis::class, 'ruang_id');
    }
}