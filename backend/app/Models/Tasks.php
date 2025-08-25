<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = ['name', 'description', 'isCompleted', 'dueDate', 'categoryId', 'userId'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
