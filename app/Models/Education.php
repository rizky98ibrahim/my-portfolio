<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'degree_name',
        'institution_name',
        'institution_address',
        'institution_url',
        'start_date',
        'end_date',
        'gpa',
        'description',
        'is_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
