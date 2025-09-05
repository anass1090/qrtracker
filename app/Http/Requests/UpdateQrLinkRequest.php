<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQrLinkRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $id = $this->route('qr'); // implicit model binding
        return [
            'slug'       => "required|string|max:120|alpha_dash|unique:qr_links,slug,{$id}",
            'target_url' => 'required|url|max:2048',
        ];
    }
}
