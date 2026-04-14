<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = ['name', 'total', 'repair', 'category_id'];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function lendingDetails()
    {
        return $this->hasMany(LendingDetail::class, 'item_id');
    }

    public function lendingTotal()
    {
        return $this->lendingDetails()
            ->whereHas('lending', function ($q) {
                $q->whereNull('return_date');
            })
            ->sum('total');
    }

    public function available()
    {
        return max(
            $this->total - $this->repair - $this->lendingTotal(),
            0
        );
    }
}
