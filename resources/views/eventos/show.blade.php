@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="row">

    <!-- Formulário de envio de perguntas -->
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm p-3">
            <h4 class="fw-bold mb-3">💬 Faça sua Pergunta</h4>

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

                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    Enviar Pergunta
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de perguntas -->
    <div class="col-md-7">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold m-0">📋 Perguntas do Evento</h4>

            <span class="text-secondary small">
                Total no Banco: {{ $perguntas->total() }}
            </span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                <div class="card-body">

                    <!-- Ticket #003 e #004: Autor da pergunta -->
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
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- Ticket #002: Botões de paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $perguntas->links() }}
        </div>

    </div>
</div>
@endsection
