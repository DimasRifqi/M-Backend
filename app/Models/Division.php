<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';
    protected $guarded =['id'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'divisions_id');
    }
}