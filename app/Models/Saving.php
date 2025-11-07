<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'tanggal_setor',
        'jumlah_setor',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }
}
