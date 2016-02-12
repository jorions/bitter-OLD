<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
     /**
     * Get the user that owns the post
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that have favorited the past
     */
    public function likes()
    {
        return $this->belongsToMany('App\User');
    }

}
