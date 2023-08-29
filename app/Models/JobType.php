<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobType extends Model
{
    protected $guarded = ['id'];

   //belongs to many vacancy
    public function vacancies(): BelongsToMany
    {
         return $this->belongsToMany(Vacancy::class, 'vacancy_job_types', 'job_type_id', 'vacancy_id');
    }
}
