<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_name' => $this->course_name,
            'capacity' => $this->capacity,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d'),
            'studio_id' => $this->studio_id
        ];
    }
}
