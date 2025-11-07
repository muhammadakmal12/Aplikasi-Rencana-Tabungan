<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'gambar',
        'nama_barang',
        'harga_barang',
        'target_tanggal',
        'status',
    ];

    public function savings()
    {
        return $this->hasMany(Saving::class, 'goal_id');
    }
}
