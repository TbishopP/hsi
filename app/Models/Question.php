<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    protected $guarded = ['id'];

    public function choices(): BelongsToMany
    {
        return $this->belongsToMany(Choice::class, 'question_choices', 'question_id', 'choice_id');
    }

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class, 'vacancy_questions', 'question_id', 'vacancy_id');
    }
}
