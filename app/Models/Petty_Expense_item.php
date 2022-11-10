<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petty_Expense_item extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function petty_expense(){
        return $this->belongsTo(Petty_expense::class);
    }
}
