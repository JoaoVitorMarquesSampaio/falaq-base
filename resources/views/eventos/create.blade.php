@extends('layouts.app')

@section('title', 'Criar Evento — FalaQ')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md text-gray-800">

    <h1 class="text-2xl font-bold mb-2">
        Criar Novo Evento
    </h1>

    <p class="text-gray-500 mb-6">
        Preencha as informações abaixo para cadastrar seu evento.
    </p>

    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf

        <!-- Titulo -->
        <div class="mb-5">

            <label for="titulo" class="block text-sm font-semibold mb-2">
                Título do evento
            </label>

            <input
                type="text"
                name="titulo"
                id="titulo"
                value="{{ old('titulo') }}"
                placeholder="Digite o título do evento"
                class="w-full border rounded-md px-4 py-3 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @else border-gray-300 @enderror"
            >

            @error('titulo')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- Descricao -->
        <div class="mb-5">

            <label for="descricao" class="block text-sm font-semibold mb-2">
                Descrição do evento
            </label>

            <textarea
                name="descricao"
                id="descricao"
                rows="5"
                placeholder="Descreva seu evento"
                class="w-full border rounded-md px-4 py-3 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descricao') border-red-500 @else border-gray-300 @enderror"
            >{{ old('descricao') }}</textarea>

            @error('descricao')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- Data -->
        <div class="mb-6">

            <label for="data_evento" class="block text-sm font-semibold mb-2">
                Data do evento
            </label>

            <input
                type="date"
                name="data_evento"
                id="data_evento"
                value="{{ old('data_evento') }}"
                class="w-full border rounded-md px-4 py-3 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('data_evento') border-red-500 @else border-gray-300 @enderror"
            >

            @error('data_evento')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>

        <!-- Botoes -->
        <div class="flex items-center justify-between gap-3">

            <a href="{{ route('eventos.index') }}"
                class="text-gray-600 hover:text-gray-900 font-medium">
                Voltar
            </a>

            <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-semibold transition-colors">
                Criar Evento
            </button>

        </div>

    </form>

</div>

@endsection
