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
            'car_model' => $this->car_model->name,
            'year' => $this->year,
            'name' =>  $this->name,
            'consumption' => $this->consumption,
            'horsepower' => $this->horsepower,
            'car_class' => $this->car_class->name,
            'salon' => $this->salon->name,
        ];
    }
}
