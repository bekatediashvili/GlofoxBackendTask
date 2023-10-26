<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'member_name' => $this->member_name,
            'booking_date' => $this->booking_date,
            'class_id' => $this->class_id,
            'user_id' => $this->user_id,
        ];
    }
}
