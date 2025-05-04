<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_name', 'part_description', 'price', 'quantity_in_stock'
    ];

    public function repairParts()
    {
        return $this->hasMany(RepairPart::class);
    }
}
