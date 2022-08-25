<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petty_expense extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);

    }

    public function petty_expense_items(){
        return $this->hasMany(Petty_Expense_item::class);
    }
}
