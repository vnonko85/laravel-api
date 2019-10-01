<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'year', 'format', 'user_id',
    ];

    public function actors(){
        return $this->belongsToMany(\App\Models\Actor::class)->withPivot('id');
    }
}
