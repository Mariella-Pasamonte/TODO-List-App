<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = ['name', 'description', 'isCompleted', 'dueDate', 'category_id', 'user_id'];
    protected $casts = ['isCompleted'=> 'boolean'];
    protected $attributes = ['isCompleted'=>false];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
