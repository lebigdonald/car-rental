<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Assuming only authenticated admins can update cars.
        return auth()->guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'model' => 'sometimes|string|max:255',
            'brand' => 'sometimes|string|max:255',
            'make_year' => 'sometimes|integer|min:1900|max:' . (now()->year + 1),
            'passenger_capacity' => 'sometimes|integer|min:1',
            'kilometers_per_liter' => 'sometimes|numeric|min:0',
            'fuel_type' => [
                'sometimes',
                Rule::in(['Diesel', 'Hybride', 'Essence', 'Électrique']),
            ],
            'transmission_type' => [
                'sometimes',
                Rule::in(['Automatique', 'Manuel']),
            ],
            'daily_rate' => 'sometimes|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'secondary_images' => 'nullable|array|max:3',
            'secondary_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
