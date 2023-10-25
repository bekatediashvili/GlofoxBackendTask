<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
      protected $fillable = ['member_name', 'class_id', 'booking_date'];

      public function course(){

          return $this->hasOne(Course::class);
      }
}
