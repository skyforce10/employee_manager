<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'date_of_birth',
        'married', 'number_of_kids', 'profile_picture', 'phone_numbers', 'company_id'
    ];

    protected $casts = [
        'phone_numbers' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
