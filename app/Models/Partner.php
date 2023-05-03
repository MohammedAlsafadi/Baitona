<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';
    protected $guarded = [];
    protected $appends = ['name', 'formatted_date'];

    public function getNameAttribute()
    {
        if(app()->getLocale() == 'ar'){
            return $this->name_ar;
        }else{
            return $this->name_en;
        }
    }

    public function getFormattedDateAttribute()
    {
        return date('Y-m-d', strtotime($this->date));
    }

    public function getImageAttribute($value)
    {
        return $value != null ? url('/images/') . '/' . $value : '';
    }
}
