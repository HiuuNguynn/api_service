<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'people';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'role',
        'address',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
