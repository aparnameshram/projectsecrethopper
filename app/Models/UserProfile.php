<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    public $guarded = [];

    public const DEFAULT_TYPE = 'user';

    public $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'timezone',
        'latitude',
        'longitude',
        'drinker_type',
        'how_did_hear',
        'recent_experience',
        'qualification_for_hopper',
        'acknowledge_text',
        'acknowledge_name',
        'date_signed',
        'practice_report'
    ];




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fields(): array
    {
        return [
            'date_of_birth',
            'address',
            'city',
            'state',
            'zip',
            'country',
            'timezone',
            'latitude',
            'longitude',
            'drinker_type',
            'how_did_hear',
            'recent_experience',
            'qualification_for_hopper',
            'acknowledge_text',
            'acknowledge_name',
            'date_signed',
            'practice_report'
        ];
    }

    public function defaultLatLong(): array
    {
        return [
            'latitude' => '19.614960',
            'longitude' => '74.618560'
        ];
    }
}
