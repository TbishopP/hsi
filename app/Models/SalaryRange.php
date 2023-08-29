<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SalaryRange extends Model
{
    protected $guarded = ['id'];

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'vacancy_salary_ranges', 'salary_range_id', 'vacancy_id');
    }
}
