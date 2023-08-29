<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Choice extends Model
{
    protected $guarded = ['id'];

    public function question(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_choices', 'choice_id', 'question_id');
    }
}
