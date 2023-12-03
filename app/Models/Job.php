<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jobs';

    protected $fillable = [
        'company_name',
        'company_logo',
        'company_url',
        'job_title',
        'job_description',
        'job_location',
        'start_date',
        'end_date',
        'is_published',
        'is_current_job',
        'is_ended_job',
        'is_remote',
        'is_freelance',

    ];
}
