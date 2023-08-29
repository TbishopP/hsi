<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SalaryRange extends Model
{
    protected $guarded = ['id'];

    public function vacancy(): HasOne
    {
        return $this->hasOne(Vacancy::class);
    }
}
