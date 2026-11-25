<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoFormRequest;
use App\Http\Requests\StorePerguntaRequest;
use App\Models\Evento;
use App\Models\Pergunta;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();

        return view('eventos.index', compact('eventos'));
    }

    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        $consulta = Pergunta::with(['user', 'evento'])
            ->withCount('votos')
            ->where('evento_id', $evento->id)
            ->where('is_public', true);

        if (Auth::check()) {
            $consulta->withExists([
                'votos as usuario_votou' => function ($query) {
                    $query->where('users.id', Auth::id());
                }
            ]);
        }

        $perguntas = $consulta
            ->orderByDesc('votos_count')
            ->latest()
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

    public function storePergunta(StorePerguntaRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'user_id'   => Auth::id(),
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
            'is_public' => false,
        ]);

        return redirect()->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada e aguarda moderação!');
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(EventoFormRequest $request)
    {
        $evento = $request->user()->eventos()->create($request->validated());

        return redirect()->route('eventos.show', $evento->id);
    }

    // Sprint 05 - Exclusao autorizada
    public function destroyPergunta(Pergunta $pergunta)
    {
        $this->authorize('delete', $pergunta);

        $eventoId = $pergunta->evento_id;

        $pergunta->delete();

        return redirect()->route('eventos.show', $eventoId)
            ->with('sucesso', 'Pergunta excluída com sucesso!');
    }

    // Sprint 06 - Votacao com toggle
    public function votar(Pergunta $pergunta)
    {
        abort_unless($pergunta->is_public, 403);

        $resultado = $pergunta->votos()->toggle(auth()->id());

        $mensagem = count($resultado['attached']) > 0
            ? 'Voto registrado com sucesso!'
            : 'Voto removido com sucesso!';

        return back()->with('sucesso', $mensagem);
    }
}
