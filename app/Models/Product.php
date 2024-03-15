<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * @return MorphMany
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translationable', 'translationable_type', 'translationable_id', 'uid');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithFilters($query): mixed
    {
        return $query->when(request()->search_term, function ($query) {
            $search_term = request()->search_term;
            $query->where(function ($query) use ($search_term) {
                $query->where("uid", 'LIKE', '%' . $search_term . '%');
            });
        })->orderBy('id', 'desc');
    }
}
