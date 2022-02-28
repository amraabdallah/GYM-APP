<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    public function managers(){
        return $this->hasMany(User::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function trainingSessions(){
        return $this->hasMany(TrainingSession::class);
    }
}
