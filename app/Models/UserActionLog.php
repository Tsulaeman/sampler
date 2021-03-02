<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActionLog extends Model
{
    use HasFactory;

    const CHECKIN = "CHECKIN";
    const CHECKOUT = "CHECKOUT";
    protected $fillable = ['book_id', 'user_id', 'action'];
    protected $appends = ['book_title', 'user_name'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBookTitleAttribute()
    {
        return $this->book()->first()->title;
    }

    public function getUserNameAttribute()
    {
        return $this->user()->first()->name;
    }
}
