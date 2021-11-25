<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function expense_items(){
        return $this->hasMany(Expense_item::class);
    }

    public function vendors(){
        return $this->hasOne(Vendor::class);
    }
}
