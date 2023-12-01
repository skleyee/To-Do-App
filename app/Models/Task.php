<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function lists()
    {
        return $this->hasOne(Category::class);
    }

    protected $fillable = [
        'user_id',
        'title',
        'is_complete',
        'category_id',
    ];

    public static function createTask($data): bool
    {
        $new_task = new Task();
        return $new_task->fill($data)->save();
    }

}
