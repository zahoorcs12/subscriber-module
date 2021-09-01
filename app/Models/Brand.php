<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name', 'url', 'logo',
    ];  
    
    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function subscribers(){
        return $this->hasMany(Subscriber::class);
    }

    
}
