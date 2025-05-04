<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_id', 'part_id', 'quantity_used', 'total_cost'
    ];

    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }
}

