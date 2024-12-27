<?php

namespace App\Http\Requests\Admin\Setting;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        $text = [
            'app_name_ar',
            'app_name_en',
            'email'
        ];
        $phones = [
            'phone',
            'whatsapp'
        ];
        $socials = [
            'facebook',
            'twitter',
            'instagram',
            'youtube',
            'snapchot',
            'tiktok',
            'app_store_url',
            'google_play_url',
        ];
        $imgs = ['logo', 'fav_icon'];
        $settings = Setting::get();
        foreach ($settings as $setting) {
            if (in_array($setting->key, $text)) {
                if ($text == 'email') {
                    $rules[$setting->key] = ['required', 'email', 'max:255'];
                } else {
                    $rules[$setting->key] = ['required', 'string', 'max:255'];
                }
            } elseif (in_array($setting->key, $phones)) {
                $rules[$setting->key] = ['sometimes', 'nullable', 'digits_between:10,15'];
            } elseif (in_array($setting->key, $socials)) {
                $rules[$setting->key] = ['sometimes', 'nullable', 'url'];
            } elseif (in_array($setting->key, $imgs)) {
                $rules[$setting->key] = ['image', 'mimetypes:image/jpeg,image/png,image/webp,image/gif', 'mimes:jpg,jpeg,jfif,png,gif,webp', 'max:5120'];
            }
        }
        return $rules;
    }
}
