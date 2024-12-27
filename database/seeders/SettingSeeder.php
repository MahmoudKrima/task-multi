<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Cache;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cache::forget('settings');
        $settings = [
            'app_name_ar' => 'App Name Ar',
            'app_name_en' => 'App Name En',
            'phone' => '0515158484',
            'email' => 'admin@gmail.com',
            'whatsapp' => '0515158484',
            'facebook' => 'https://www.facebook.com',
            'twitter' => 'https://twitter.com',
            'instagram' => 'https://www.instagram.com',
            'youtube' => 'https://www.youtube.com',
            'snapchat' => 'https://www.snapchat.com',
            'tiktok' => 'https://www.tiktok.com',
            'app_store_url' => '',
            'google_play_url' => '',
            'logo' => 'defaults/admin.jpg',
            'fav_icon' => 'defaults/admin.jpg',
        ];
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
