<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['course_name', 'capacity', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function studioMember()
    {

        return $this->belongsTo(Studio::class);
    }
}
