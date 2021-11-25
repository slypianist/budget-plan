<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_item extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function expense(){
        return $this->belongsTo(Expense::class);
    }
}
