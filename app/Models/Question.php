<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    protected $guarded = ['id'];

    public function choices(): BelongsToMany
    {
        return $this->belongsToMany(Choice::class, 'question_choice', 'question_id', 'choice_id');
    }
}
