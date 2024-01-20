<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'grammage',
        'status',
    ];

    public function imagePath()
    {
        if ($this->image) {
            return storage_path("app/public/products/{$this->id}/{$this->image}");
        }

        return null;
    }
}
