<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComments extends Model
{
    protected $table = 'blog_comments';
    protected $fillable = ['blog_page_id', 'comment'];
}
