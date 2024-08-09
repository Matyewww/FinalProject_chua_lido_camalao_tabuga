<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'author',
        'content',
        'published_date',
        'photo'
    ];

    protected $casts = [
        'photo' => 'array', // Casting photo column to an array
        // 'published_date' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPhotoUrlsAttribute() {
        $urls = [];
        foreach ($this->photo as $path) {
            $urls[] = asset('storage/storage/user' . basename($path));
        }
        return $urls;
    }
}