<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car_model_id' => $this->car_model_id,
            'year' => $this->year,
            'consumption' => $this->consumption,
            'horsepower' => $this->horsepower,
            'car_class_id' => $this->car_class_id,
            'salon_id' => $this->salon_id,
        ];
    }
}
