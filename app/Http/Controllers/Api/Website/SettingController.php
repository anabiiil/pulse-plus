<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\SettingResource;
use App\Models\Setting;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of all settings.
     * This can be used in the website layout (Vue) to access settings globally.
     */
    public function index(Request $request)
    {
        $settings = Setting::all();

        return $this->responseData(SettingResource::collection($settings));
    }

    /**
     * Display the specified setting by ID.
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return $this->responseData(new SettingResource($setting));
    }

    /**
     * Get a setting by its slug.
     * Useful for accessing specific settings like 'site_name', 'contact_email', etc.
     */
    public function getBySlug($slug)
    {
        $setting = Setting::where('slug', $slug)->firstOrFail();

        return $this->responseData(new SettingResource($setting));
    }

    /**
     * Get all settings formatted as key-value pairs (slug => content).
     * This is useful for Vue layouts that need quick access to settings.
     * Both authenticated and guest users can access this.
     */
    public function getAll(Request $request)
    {
        $settings = Setting::all();

        $formattedSettings = [];
        foreach ($settings as $setting) {
            $formattedSettings[$setting->slug] = [
                'id' => $setting->id,
                'title' => $setting->title,
                'content' => $setting->content,
            ];
        }

        return $this->responseData($formattedSettings);
    }
}

