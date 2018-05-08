<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends BaseModel
{
    use SoftDeletes;

    protected $casts = [
    	'title' => 'desc',
    	'desc' => 'string',
        'destiny_id' => 'int',
        'user_id' => 'int',
    ];

    protected $fillable = [
    	'title',
    	'desc',
    	'rating',
        'destiny_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destiny()
    {
    	return $this->belongsTo(Destiny::class);
    }
}
