<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'comment',
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }    
}
