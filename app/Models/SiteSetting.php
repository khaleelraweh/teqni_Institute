<?php

namespace App\Models;

use App\Helper\MySlugHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class SiteSetting extends Model
{
    use HasFactory, HasTranslations, SearchableTrait;

    protected $guarded = [];


    public $translatable = ['value'];


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }


    protected $searchable = [
        'columns' => [

            'site_settings.name' => 10,
        ]
    ];

    public function status()
    {
        return $this->status ? __('panel.status_active') : __('panel.status_inactive');
    }

    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
    public function firstMedia(): MorphOne
    {
        return $this->MorphOne(Photo::class, 'imageable')->orderBy('file_sort', 'asc');
    }
    public function lastMedia(): MorphOne
    {
        return $this->MorphOne(Photo::class, 'imageable')->orderBy('file_sort', 'desc');
    }
}
