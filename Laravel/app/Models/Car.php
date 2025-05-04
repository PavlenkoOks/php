<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'brand', 'model', 'year', 'registration_number'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }
}
