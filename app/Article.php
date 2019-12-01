<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use SoftDeletes;
 
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'title', 'content'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
