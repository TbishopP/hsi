<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function salaryRange(): BelongsTo
    {
        return $this->belongsTo(SalaryRange::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function employerLogo(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'employer_logo');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'vacancy_questions', 'vacancy_id', 'question_id');
    }
}
