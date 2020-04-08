<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueParticipant;
use Auth;

class CreateParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName'                 => 'required|string',
            'lastName'                  => 'required|string',
            'classroomId'               => [
                'required',
                'integer',
                'exists:classrooms,id',
                new UniqueParticipant($this->firstName, $this->lastName, $this->classroomId)
            ],
            'isAgreed'                  => 'required|accepted',
            'imageFile'                 => 'nullable|image'
        ];
    }
}
