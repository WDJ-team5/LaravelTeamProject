<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['article_id', 'filename', 'bytes', 'mime'];
}
