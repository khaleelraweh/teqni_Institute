<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class VideoLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function video_linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
