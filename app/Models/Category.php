<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id'
    ];

    public function lists()
    {
        return $this->hasMany(Task::class);
    }

    public static function createCategory($title)
    {
        $new_category = new Category();
        $data = [
            'title' => $title,
            'user_id' => Auth::id(),
        ];
        $new_category->fill($data)->save();
    }

    public static function getCategoriesForUser(): array
    {
        $data = Category::where('user_id', Auth::id())->get();
        $categories = [];
        foreach ($data as $category) {
            $categories[$category['id']] = $category;
        }

        return $categories;
    }

    public static function setCategoryToData($data)
    {
        if (isset($data['category_id']) && $data['category_id'] === 'new') {
            unset($data['category_id']);
        }
        if (isset($data['new_category'])) {
            Category::createCategory($data['new_category']);
            $category_id = Category::select('id')->where('title', $data['new_category'])->first()->id;
            $data['category_id'] = $category_id;
        }
        return $data;
    }
}
