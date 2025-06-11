<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'banners';
    public $timestamps = true;
    public function creator()
    {
        return $this->belongsTo(AdminUser::class, 'created_by', 'id');
    }
}
