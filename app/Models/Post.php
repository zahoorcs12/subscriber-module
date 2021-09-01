<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'brand_id'
    ];


    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function subscriber(){
        return $this->belongsTo(Subscriber::class);
    }
}
