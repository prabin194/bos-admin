<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['fileType', 'url'];

    /**
     * @return string
     */
    public function getFileTypeAttribute(): string
    {
        $type = explode('/', $this->type);
        $document_type = explode('.', $this->name);
        if ($type[0] === 'application' && $document_type[1] === 'pdf') {
            return $document_type['1'];
        }
        return $type[0];
    }

    /**
     * @param $url
     * @return string
     */
    public function getUrlAttribute($url): string
    {
        return $this->domain->url ?? env('APP_BASE_URL') . '/' . $this->attributes['url'];
    }

    /**
     * @return null
     */
    public function getCreatedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('h:i a, M d Y') : null;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
