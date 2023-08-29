<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vacancy extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'posting_start_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function jobTypes(): BelongsToMany
    {
        return $this->belongsToMany(JobType::class, 'vacancy_job_types', 'vacancy_id', 'job_type_id');
    }

    public function continents(): BelongsToMany
    {
        return $this->belongsToMany(Continent::class, 'vacancy_continents', 'vacancy_id', 'continent_id');
    }

    public function sectors(): BelongsToMany
    {
        return $this->belongsToMany(Sector::class, 'vacancy_sectors', 'vacancy_id', 'sector_id');
    }

    public function salaryRanges(): BelongsToMany
    {
        return $this->belongsToMany(SalaryRange::class, 'vacancy_salary_ranges', 'vacancy_id', 'salary_range_id');
    }
}
