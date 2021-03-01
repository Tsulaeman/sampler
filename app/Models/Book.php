<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'published_at', 'isbn', 'status'
    ];

    const AVAILABLE = "AVAILABLE";
    const CHECKED_OUT = "CHECKED_OUT";

    public function bookActionLogs()
    {
        return $this->hasMany(UserActionLog::class);
    }
}
