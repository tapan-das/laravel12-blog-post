<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;


class BlogPages extends Model
{
    // use Sluggable;
    protected $table = 'blog_pages';

    public function sluggable(): array
    {
        return [
            'page_slug' => [
                'source' => 'meta_title'
            ]
        ];
    }

    public function blogcomments(): HasMany
    {
        return $this->hasMany(BlogComments::class, 'blog_page_id');
    }
}
