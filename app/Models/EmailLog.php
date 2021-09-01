<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailLog extends Model
{
    use HasFactory,SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'subscriber_id',
        'status_id',
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function subscriber(){
        return $this->belongsTo(Subscriber::class);
    }
}
