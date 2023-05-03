<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'sliders';
    protected $guarded = [];
    protected $appends = ['title', 'desc'];

    public function getTitleAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->title_ar;
        } else {
            return $this->title_en;
        }
    }

    public function getDescAttribute()
    {
        if (app()->getLocale() == 'ar') {
            return $this->desc_ar;
        } else {
            return $this->desc_en;
        }
    }

    public function getImageAttribute($value)
    {
        return $value != null ? url('/images/') . '/' . $value : '';
    }
}
