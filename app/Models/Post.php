<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'person_id',
        'title',
        'content',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id_user');
    }
}
