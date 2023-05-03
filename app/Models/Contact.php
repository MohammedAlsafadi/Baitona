<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    use HasFactory;
    use HasFactory;
    protected $table = 'contacts';
    protected $guarded = [];
    protected $appends = ['name', 'message'];

    public function getNameAttribute()
    {
        if(app()->getLocale() == 'ar'){
            return $this->name_ar;
        }else{
            return $this->name_en;
        }
    }

    public function getMessageAttribute()
    {
        if(app()->getLocale() == 'ar'){
            return $this->message_ar;
        }else{
            return $this->message_en;
        }
    }
}
