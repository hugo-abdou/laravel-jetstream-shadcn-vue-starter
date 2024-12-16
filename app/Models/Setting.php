<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Settings as SettingsFacade;

class Setting extends Model
{

    protected $fillable = [
        'name',
        'payload'
    ];

    protected $casts = [
        'payload' => 'array'
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::saved(function ($setting) {
            SettingsFacade::put($setting->name, $setting->payload);
        });

        static::deleted(function ($setting) {
            SettingsFacade::forget($setting->name);
        });
    }
}
