<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('commission', 'about_app', 'commission_info', 'info', 'max_credit','facebook','twitter','instagram');

}
