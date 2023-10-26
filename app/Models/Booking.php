<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
      protected $fillable = ['member_name', 'class_id', 'booking_date', 'user_id'];

      protected $casts =[
        'booking_date' =>  'date:Y-m-d'
      ];

      public function course(){

          return $this->hasOne(Course::class);
      }
      public function user(){
          return $this->hasOne(User::class);
      }
}
