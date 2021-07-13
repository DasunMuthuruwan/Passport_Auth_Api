<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = ['title', 'description', 'cost', 'author_id'];

    protected $visible = ['id', 'title', 'description', 'cost', 'author_id'];

    public $timestamps = false;


}
