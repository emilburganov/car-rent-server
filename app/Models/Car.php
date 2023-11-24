<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    public function car_model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }
    public function car_class(): BelongsTo
    {
        return $this->belongsTo(CarClass::class);
    }

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }
    protected $guarded = false;
}
