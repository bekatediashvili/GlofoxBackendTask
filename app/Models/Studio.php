<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function owner()
    {

        return $this->belongsToMany(User::class,);

    }

    public function courses()
    {

        return $this->hasMany(Course::class);

    }

    public function members()
    {
        return $this->belongsToMany(User::class ,'studio_members')
            ->withPivot('id');
    }

}
