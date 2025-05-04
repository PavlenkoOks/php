<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id', 'repair_date', 'repair_type', 'cost'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function repairParts()
    {
        return $this->hasMany(RepairPart::class);
    }
}
