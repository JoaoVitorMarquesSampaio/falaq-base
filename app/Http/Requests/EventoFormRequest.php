<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'      => 'required|string|max:255',
            'descricao'   => 'required|string',
            'data_evento' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O titulo do evento e obrigatorio.',
            'titulo.string' => 'O titulo deve ser um texto.',
            'titulo.max' => 'O titulo deve ter no maximo 255 caracteres.',
            'descricao.required' => 'A descricao do evento e obrigatoria.',
            'descricao.string' => 'A descricao deve ser um texto.',
            'data_evento.date' => 'Informe uma data valida.',
        ];
    }
}
