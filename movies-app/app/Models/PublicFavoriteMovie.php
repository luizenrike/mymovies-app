<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicFavoriteMovie extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'movie_id'];
}
