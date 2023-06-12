<?php

namespace App\Models;

use App\Events\EncryptData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'contenu'];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            event(new EncryptData($model));
        });
    }
};
