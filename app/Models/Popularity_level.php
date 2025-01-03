<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Popularity_level extends Model
{
    protected $fillable = ['name'];
    public function posts():BelongsToMany{
        return $this->belongsToMany(Post::class, 'Post_popularity');
    }
}
