<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'article_type'];
	
	public function attachments(){
		return $this->hasMany(Attachment::class);
	}

    public function user()
    {
        return $this->belongsTo('App\User');
    }
	
	public function getBytesAttribute($value){
		return format_filesize($value);
	}

}
