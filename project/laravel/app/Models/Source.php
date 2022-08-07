<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Source extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_WEB = 0;
    const TYPE_MOBILE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'name',
        'type',
        'domain',
        'status',
    ];

    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public static function getTypeOptions()
    {
        return [
            self::TYPE_WEB => 'Web',
            self::TYPE_MOBILE => 'Mobile',
        ];
    }

    /**
     * relationship with the submission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * relationship with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
