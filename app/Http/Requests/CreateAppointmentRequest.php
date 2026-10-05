<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pet_id' => 'required|uuid|exists:pets,id',
            'doctor_name' => 'required|string|max:150',
            'service_type' => 'required|string|max:50',
            'benefit_definition_id' => 'nullable|uuid|exists:benefit_definitions,id',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required|date_format:H:i',
            'duration_minutes' => 'nullable|integer|min:15|max:180',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'pet_id.required' => 'Debe seleccionar un paciente.',
            'pet_id.exists' => 'El paciente seleccionado no existe.',
            'doctor_name.required' => 'El nombre del médico veterinario es obligatorio.',
            'date.required' => 'La fecha de la cita es requerida.',
            'time.required' => 'La hora de la cita es requerida.',
            'duration_minutes.min' => 'La duración mínima es de 15 minutos.',
            'duration_minutes.max' => 'La duración máxima es de 180 minutos.',
        ];
    }
}
