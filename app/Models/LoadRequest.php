<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadRequest extends Model
{
    protected $fillable = ['user_id', 'amount', 'status', 'proof_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}