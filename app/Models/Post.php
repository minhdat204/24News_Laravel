<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Post extends Model
{
    protected $fillable = ['title', 'content','image_path', 'author_id', 'category_id'];
    public function category():BelongsTo{
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function author():BelongsTo{
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function tags(): BelongsToMany{
        return $this->belongsToMany(Tags::class, 'Post_tags', 'post_id', 'tag_id');
    }
    public function popularityLevel(): BelongsToMany
    {
        return $this->belongsToMany(Popularity_level::class, 'Post_popularity', 'post_id', 'level_id');
    }
}