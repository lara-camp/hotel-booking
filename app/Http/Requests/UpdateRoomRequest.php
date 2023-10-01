<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role_id === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'room_number' => 'required|integer|unique:rooms,room_number,' . $this->room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'bed_type' => 'required|string',
            'number_of_bed' => 'required|integer',
            'price' => 'required|integer',
            'available' => 'required|boolean',
        ];
    }
}
