<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
     use HasFactory;

    protected $fillable = [
        'amount',
        'reason',
        'beneficiary',
        'created_by',
        'date'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
