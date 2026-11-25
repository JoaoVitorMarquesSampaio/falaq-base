@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-white mb-2">
        {{ $evento->titulo }}
    </h1>

    <p class="text-gray-400">
        {{ $evento->descricao }}
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Formulario de perguntas -->
    <div>

        <div class="bg-gray-800 rounded-lg shadow-md p-6">

            <h2 class="text-xl font-bold text-white mb-4">
                💬 Faça sua Pergunta
            </h2>

            @auth

                <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="evento_id" value="{{ $evento->id }}">

                    <div class="mb-4">

                        <label for="texto" class="block text-sm font-semibold text-gray-300 mb-2">
                            Texto da Pergunta
                        </label>

                        <textarea
                            name="texto"
                            id="texto"
                            rows="4"
                            placeholder="Digite sua pergunta..."
                            class="w-full border rounded-md bg-gray-900 text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('texto') border-red-500 @else border-gray-600 @enderror"
                        >{{ old('texto') }}</textarea>

                        @error('texto')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('evento_id')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <p class="text-gray-400 text-sm mb-4">
                        Sua pergunta será exibida após aprovação da moderação.
                    </p>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 font-semibold">
                        Enviar Pergunta
                    </button>

                </form>

            @else

                <div class="text-center py-3">

                    <p class="text-gray-400 mb-4">
                        Você precisa estar conectado para enviar perguntas.
                    </p>

                    <a href="{{ route('login.create') }}"
                        class="block bg-blue-600 text-white px-4 py-3 rounded-md hover:bg-blue-700 mb-3 no-underline">
                        Fazer Login
                    </a>

                    <a href="{{ route('register.create') }}"
                        class="block border border-gray-500 text-white px-4 py-3 rounded-md hover:bg-gray-700 no-underline">
                        Criar Conta
                    </a>

                </div>

            @endauth

        </div>

    </div>

    <!-- Sprint 06 - Ranking de perguntas -->
    <div>

        <div class="flex justify-between items-center mb-2">

            <h2 class="text-xl font-bold text-white">
                🏆 Ranking de Perguntas
            </h2>

            <span class="text-gray-400 text-sm">
                Públicas: {{ $perguntas->total() }}
            </span>

        </div>

        <p class="text-gray-400 text-sm mb-5">
            As perguntas mais votadas aparecem primeiro.
        </p>

        @forelse($perguntas as $pergunta)

            <div class="flex items-start gap-3 mb-5">

                <!-- Avatar -->
                <div class="shrink-0 w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                    {{ mb_strtoupper(mb_substr($pergunta->user->name ?? 'Anônimo', 0, 1)) }}
                </div>

                <!-- Balao de conversa -->
                <div class="flex-1 min-w-0">

                    <div class="bg-gray-800 rounded-xl rounded-tl-none p-4 shadow-md">

                        <div class="flex justify-between items-center mb-2">

                            <p class="text-blue-400 font-semibold text-sm">
                                {{ $pergunta->user->name ?? 'Anônimo' }}
                            </p>

                            <span class="text-yellow-400 font-bold text-sm">
                                #{{ $perguntas->firstItem() + $loop->index }}
                            </span>

                        </div>

                        <p class="text-white break-words mb-3">
                            {{ $pergunta->texto }}
                        </p>

                        <div class="flex flex-wrap justify-between items-center gap-2 text-xs text-gray-400">

                            <span class="bg-gray-700 rounded-full px-3 py-1">
                                {{ $pergunta->status }}
                            </span>

                            <span>
                                {{ $pergunta->created_at->format('d/m/Y H:i') }}
                            </span>

                        </div>

                        <!-- Acoes da pergunta -->
                        <div class="flex flex-wrap items-center justify-between gap-3 mt-4">

                            <!-- Sprint 06 - Botao de voto -->
                            @auth

                                <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-md font-semibold text-sm transition-colors
                                        {{ $pergunta->usuario_votou
                                            ? 'bg-blue-600 text-white hover:bg-blue-700'
                                            : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}"
                                        aria-pressed="{{ $pergunta->usuario_votou ? 'true' : 'false' }}"
                                        title="{{ $pergunta->usuario_votou ? 'Remover voto' : 'Votar nesta pergunta' }}"
                                    >
                                        👍 {{ $pergunta->votos_count }}

                                        {{ $pergunta->usuario_votou ? 'Votado' : 'Votar' }}

                                    </button>

                                </form>

                            @else

                                <span class="bg-gray-700 text-gray-300 px-4 py-2 rounded-md text-sm">
                                    👍 {{ $pergunta->votos_count }} votos
                                </span>

                            @endauth

                            <!-- Sprint 05 - Exclusao autorizada -->
                            @can('delete', $pergunta)

                                <form
                                    action="{{ route('perguntas.destroy', $pergunta) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta pergunta?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <x-danger-button class="text-sm">
                                        Excluir Pergunta
                                    </x-danger-button>

                                </form>

                            @endcan

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="bg-gray-800 rounded-lg p-6 text-center text-gray-400">
                Nenhuma pergunta pública disponível no momento.
            </div>

        @endforelse

        <!-- Paginacao -->
        <div class="mt-6">
            {{ $perguntas->links() }}
        </div>

    </div>

</div>

@endsection
