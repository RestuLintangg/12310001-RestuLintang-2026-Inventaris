<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    //
    protected $fillable = ['name', 'user_id', 'ket', 'total', 'date', 'return_date', 'edited_by'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function lendingDetails() {
        return $this->hasMany(LendingDetail::class);
    }
}
