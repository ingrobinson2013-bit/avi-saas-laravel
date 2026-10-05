<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorefrontEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tutor_name' => 'required|string|max:255',
            'tutor_phone' => 'required|string|max:50',
            'tutor_email' => 'required|email|max:255',
            'tutor_doc' => 'nullable|string|max:50',
            'pet_name' => 'required|string|max:255',
            'pet_species' => 'required|string|in:Canino,Felino,dog,cat,Perro,Gato,canino,felino,perro,gato',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|string|max:50',
            'pet_photo_base64' => 'nullable|string',
            'plan_slug' => 'nullable|string',
            'billing_cycle' => 'nullable|string|in:monthly,annual',
            'payment_method' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'tutor_name.required' => 'El nombre completo del tutor es obligatorio.',
            'tutor_phone.required' => 'El número de teléfono / WhatsApp es requerido para el carnet digital.',
            'tutor_email.required' => 'El correo electrónico es necesario para enviar el certificado.',
            'tutor_email.email' => 'Por favor ingrese un correo electrónico válido.',
            'pet_name.required' => 'El nombre de la mascota es obligatorio.',
            'pet_species.required' => 'Debe seleccionar si su mascota es Perro o Gato.',
            'pet_species.in' => 'La especie debe ser Canino (Perro) o Felino (Gato).',
            'billing_cycle.in' => 'El ciclo de facturación debe ser mensual o anual.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Por favor verifique los datos del formulario.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
