@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')

@if(session('sucesso'))
    <div class="alert alert-success mb-4">
        {{ session('sucesso') }}
    </div>
@endif

<div class="row">

    <!-- Formulario de envio de perguntas -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold mb-3">💬 Faça sua Pergunta</h4>

            @auth

                <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="evento_id" value="{{ $evento->id }}">

                    <div class="mb-3">
                        <label for="texto" class="form-label text-secondary">
                            Texto da Pergunta
                        </label>

                        <textarea name="texto" id="texto" rows="4"
                            class="form-control bg-dark text-white border-secondary @error('texto') is-invalid @enderror"
                            placeholder="Digite sua dúvida ou comentário para o palestrante...">{{ old('texto') }}</textarea>

                        @error('texto')
                            <div class="invalid-feedback fw-bold">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('evento_id')
                            <div class="text-danger small">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <p class="text-secondary small">
                        Sua pergunta será exibida após aprovação da moderação.
                    </p>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        Enviar Pergunta
                    </button>
                </form>

            @else

                <div class="text-center py-3">
                    <p class="text-secondary">
                        Você precisa estar conectado para enviar perguntas.
                    </p>

                    <a href="{{ route('login.create') }}"
                        class="btn btn-primary w-100 mb-2">
                        Fazer Login
                    </a>

                    <a href="{{ route('register.create') }}"
                        class="btn btn-outline-secondary w-100">
                        Criar Conta
                    </a>
                </div>

            @endauth

        </div>
    </div>

    <!-- Lista de perguntas publicas -->
    <div class="col-md-7">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>

            <span class="text-secondary small">
                Perguntas públicas: {{ $perguntas->total() }}
            </span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">

                    <!-- Autor da pergunta -->
                    <div class="fw-bold text-primary mb-2">
                        👤 {{ $pergunta->user->name ?? 'Anônimo' }}
                    </div>

                    <p class="fs-5 mb-2 text-white">
                        {{ $pergunta->texto }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center text-secondary small">
                        <span>
                            Status:
                            <span class="badge bg-success">
                                {{ $pergunta->status }}
                            </span>
                        </span>

                        <span>
                            {{ $pergunta->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>

                </div>
            </div>
        @empty
            <div class="alert alert-dark text-center p-4">
                Nenhuma pergunta pública disponível no momento.
            </div>
        @endforelse

        <!-- Botoes de paginacao -->
        <div class="d-flex justify-content-center mt-4">
            {{ $perguntas->links() }}
        </div>

    </div>
</div>
@endsection
