<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'person_id', 'id_user');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
