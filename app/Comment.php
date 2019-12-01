<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use SoftDeletes;
 
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'commentable_type', 'commentable_id', 'parent_id', 'content'];
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
