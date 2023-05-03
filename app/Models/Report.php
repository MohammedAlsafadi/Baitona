<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $guarded = [];
    protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        if ($this->type == 1){
            return __('common.Administrative');
        }else{
            return __('common.Financial');
        }
    }

    public function getFileAttribute($value)
    {
        return $value != null ? url('/files/') . '/' . $value : '';
    }
}
