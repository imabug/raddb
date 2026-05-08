<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShieldingRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Mass assignable attributes
     * @var array<string>
     */
    protected $fillable = [
        'description',
        'request_date',
        'machine_id',
        'user_id',
        'status',
        'completion_date',
        'notes'
    ];

    /**
     * Attribute casting
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_date' => 'date:Y-m-d',
        'completion_date' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
     * Relationships
     */
    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Scope functions
     */

    /**
     * Scope function to return in progress shielding plan requests
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'In progress'); 
    }

    /**
     * Scope function to return completed shielding plan requests
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'Complete');
    }

    /**
     * Scope function to return shielding plans awaiting info
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeNeedInfo(Builder $query): Builder
    {
        return $query->where('status', 'Need info');
    }
}
