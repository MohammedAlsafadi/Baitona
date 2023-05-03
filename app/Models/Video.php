<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    protected $guarded = [];
    protected $appends = ['title'];

    public function getTitleAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    // public function getLinkAttribute()
    // {
    //     if (app()->getLocale() == 'ar') {
    //         return $this->link;
    //     }
    // }

    public function getVideoAttribute($value)
    {
        return $value != null ? url('/videos/') . '/' . $value : '';
    }
}
