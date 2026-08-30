<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_type',
        'location',
        'contact_phone',
        'contact_email',
        'website',
        'description',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
        ];
    }
}
