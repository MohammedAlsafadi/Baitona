<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['title', 'desc', 'program_title'];
    protected $hidden = ['program'];

    public function program(){
        return $this->belongsTo(Program::class);
    }

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

    public function getProgramTitleAttribute()
    {
        return $this->program->title;
    }

    public function getImageAttribute($value)
    {
        return $value != null ? url('/images/') . '/' . $value : '';
    }

}
