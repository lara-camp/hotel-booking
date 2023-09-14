<?php

namespace App\Http\Requests;

use App\Models\RoomType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRoomTypeRequest extends FormRequest
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
    public function rules(RoomType $room_type): array
    {
        return [
            'name' => 'required|string|max:255|unique:room_types,name,'.$room_type->id
        ];
    }
}
