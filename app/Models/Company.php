<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'website', 'logo'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
