<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, $default = null): ?string
    {
        return self::where('key', $key)->value('value') ?? $default;
    }
}
