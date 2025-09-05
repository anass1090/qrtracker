<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreQrLinkRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'slug'       => 'required|string|max:120|alpha_dash|unique:qr_links,slug',
            'target_url' => 'required|url|max:2048',
        ];
    }
}
