<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Z3d0X\FilamentFabricator\Models\Contracts\Page as Contract;

class Page extends Model implements Contract
{
    public function __construct(array $attributes = [])
    {
        if (blank($this->table)) {
            $this->setTable(config('filament-fabricator.table_name', 'pages'));
        }

        parent::__construct($attributes);
    }

    protected $fillable = [
        'title',
        'slug',
        'blocks',
        'layout',
        'parent_id',
        'featured_image',
        'thumbnail_image',
        'short_description',
    ];

    protected $casts = [
        'blocks' => 'array',
        'parent_id' => 'integer',
    ];

    protected static function booted()
    {
        static::saved(fn () => Cache::forget('filament-fabricator::page-urls'));
        static::deleted(fn () => Cache::forget('filament-fabricator::page-urls'));
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function allChildren(): HasMany
    {
        return $this->children()->select('id', 'slug', 'title', 'parent_id')->with('children:id,slug,title,parent_id');
    }

    public function featuredImage(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'featured_image');
    }

    public function thumbnailImage(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'thumbnail_image');
    }

    public function getSlugAttribute($value)
    {
        if ($this->layout == 'news' && !str_contains($value, 'pub-hub/pub-hub-news')) {
            return 'pub-hub/pub-hub-news/' . $value;
        } elseif ($this->layout == 'accreditation' && !str_contains($value, 'pub-hub/accreditations-for-pubs')) {
            return 'pub-hub/accreditations-for-pubs/' . $value;
        }
        return $value;
    }
}
