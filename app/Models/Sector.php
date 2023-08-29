<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sector extends Model
{
    protected $guarded = ['id'];

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'vacancy_sectors', 'sector_id', 'vacancy_id');
    }
}
