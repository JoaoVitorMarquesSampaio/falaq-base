@extends('layouts.app')

@section('title', 'Painel de Moderação — FalaQ')

@section('content')

<div class="mb-6">

    <a href="{{ route('eventos.show', $evento->id) }}"
        class="text-blue-400 hover:text-blue-300 no-underline">
        ← Voltar ao evento
    </a>

    <h1 class="text-3xl font-bold text-white mt-4 mb-2">
        🛡️ Painel de Moderação
    </h1>

    <p class="text-gray-400">
        {{ $evento->titulo }}
    </p>

</div>

<div class="bg-gray-800 rounded-lg shadow-md p-6">

    <div class="flex flex-wrap justify-between items-center gap-3 mb-6">

        <h2 class="text-xl font-bold text-white">
            Denúncias recebidas
        </h2>

        <span class="bg-gray-700 text-gray-300 px-4 py-2 rounded-md">
            Total: {{ $moderacoes->total() }}
        </span>

    </div>

    @error('status')
        <div class="bg-red-900 text-red-200 rounded-md p-3 mb-4">
            {{ $message }}
        </div>
    @enderror

    @forelse($moderacoes as $moderacao)

        <div class="bg-gray-900 border border-gray-700 rounded-lg p-5 mb-4">

            <div class="flex flex-wrap justify-between items-center gap-3 mb-4">

                <span class="text-blue-400 font-semibold">
                    Denúncia #{{ $moderacao->id }}
                </span>

                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    {{ $moderacao->status === 'aprovado'
                        ? 'bg-green-900 text-green-300'
                        : ($moderacao->status === 'rejeitado'
                            ? 'bg-red-900 text-red-300'
                            : 'bg-yellow-900 text-yellow-300') }}">

                    {{ ucfirst($moderacao->status) }}

                </span>

            </div>

            <p class="text-gray-400 text-sm font-semibold mb-1">
                Pergunta denunciada
            </p>

            <p class="text-white break-words mb-4">
                {{ $moderacao->pergunta->texto }}
            </p>

            <p class="text-gray-400 text-sm font-semibold mb-1">
                Motivo da denúncia
            </p>

            <p class="text-white break-words mb-4">
                {{ $moderacao->motivo }}
            </p>

            <p class="text-gray-500 text-xs mb-4">
                Registrada em:
                {{ $moderacao->created_at->format('d/m/Y H:i') }}
            </p>

            <form
                action="{{ route('moderacoes.updateStatus', $moderacao) }}"
                method="POST"
                class="flex flex-wrap items-center gap-3"
            >

                @csrf
                @method('PATCH')

                <label for="status-{{ $moderacao->id }}"
                    class="text-gray-300 text-sm font-semibold">
                    Alterar status:
                </label>

                <select
                    name="status"
                    id="status-{{ $moderacao->id }}"
                    class="bg-gray-800 text-white border border-gray-600 rounded-md px-3 py-2"
                >

                    <option value="analisando"
                        @selected($moderacao->status === 'analisando')>
                        Analisando
                    </option>

                    <option value="aprovado"
                        @selected($moderacao->status === 'aprovado')>
                        Aprovado
                    </option>

                    <option value="rejeitado"
                        @selected($moderacao->status === 'rejeitado')>
                        Rejeitado
                    </option>

                </select>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold"
                >
                    Atualizar Status
                </button>

            </form>

        </div>

    @empty

        <div class="bg-gray-900 rounded-lg p-8 text-center">

            <p class="text-gray-400 mb-2">
                Nenhuma denúncia registrada.
            </p>

            <p class="text-gray-500 text-sm">
                As denúncias deste evento aparecerão aqui.
            </p>

        </div>

    @endforelse

    <div class="mt-6">
        {{ $moderacoes->links() }}
    </div>

</div>

@endsection
