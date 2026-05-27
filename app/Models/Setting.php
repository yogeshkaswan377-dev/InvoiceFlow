<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    
    protected $casts = [
        'value' => 'json'
    ];
    
    public static function getAllSettings()
    {
        $settings = self::all();
        $settingsArray = [];
        
        foreach($settings as $setting) {
            $settingsArray[$setting->key] = $setting->value;
        }
        
        return $settingsArray;
    }
}