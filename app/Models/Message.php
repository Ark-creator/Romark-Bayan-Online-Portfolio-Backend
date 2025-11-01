<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * This is a security feature to prevent users from
     * trying to update fields you don't want them to (like 'read' or 'id').
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
