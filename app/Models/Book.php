<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class Book extends Model
{
    use HasFactory;

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function averageRating()
    {
        $ratings = $this->ratings;

        if ($ratings->isEmpty()) {
            return 0;
        }

        $totalRating = $ratings->sum('rating');
        $averageRating = $totalRating / $ratings->count();

        return $averageRating;
    }
}
