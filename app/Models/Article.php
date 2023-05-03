<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $column = 'type';
    protected $table = 'articles';
    protected $guarded = [];
    protected $appends = ['title', 'short_desc', 'full_desc'];

    public function getTitleAttribute()
    {
        if(app()->getLocale() == 'ar'){
            return $this->title_ar;
        }else{
            return $this->title_en;
        }
    }

    public function getShortDescAttribute()
    {
        if(app()->getLocale() == 'ar'){
            return $this->short_desc_ar;
        }else{
            return $this->short_desc_en;
        }
    }

    public function getFullDescAttribute()
    {
        if(app()->getLocale() == 'ar'){
            return $this->full_desc_ar;
        }else{
            return $this->full_desc_en;
        }
    }

    // public function getTypeAttribute()
    // {
    //     if($this->type == 1){
    //         return "article";
    //     }else{
    //         return "ads";
    //     }

    // }

    public function getImageAttribute($value)
    {
        return $value != null ? url('/images/') . '/' . $value : '';
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
