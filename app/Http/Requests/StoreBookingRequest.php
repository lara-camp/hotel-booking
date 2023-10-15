<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role_id === 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'room_id.*' => 'nullable|exists:rooms,id',
            "guest_name"=>"nullable|min:3|max:256",
            'total_person'=>"nullable|integer|min:1",
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
        ];
    }
}
