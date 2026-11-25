<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeracaoRequest;
use App\Models\Evento;
use App\Models\Pergunta;
use App\Models\Moderacao;
use Illuminate\Http\Request;

class ModeracaoController extends Controller
{
    // Registrar uma denuncia
    public function store(StoreModeracaoRequest $request, Pergunta $pergunta)
    {
        $pergunta->moderacoes()->create([
            'motivo' => $request->validated()['motivo'],
            'status' => 'analisando',
        ]);

        return back()->with(
            'sucesso',
            'Denúncia enviada com sucesso!'
        );
    }

    // Listar as denuncias do evento
    public function index(Evento $evento)
    {
        $this->authorize('moderate', $evento);

        $moderacoes = Moderacao::with('pergunta')
            ->whereHas('pergunta', function ($query) use ($evento) {
                $query->where('evento_id', $evento->id);
            })
            ->latest()
            ->paginate(15);

        return view('moderacoes.index', compact(
            'evento',
            'moderacoes'
        ));
    }

    // Atualizar o status da denuncia
    public function updateStatus(Request $request, Moderacao $moderacao)
    {
        $this->authorize(
            'moderate',
            $moderacao->pergunta->evento
        );

        $dados = $request->validate([
            'status' => 'required|in:analisando,aprovado,rejeitado',
        ]);

        $moderacao->update([
            'status' => $dados['status'],
        ]);

        return back()->with(
            'sucesso',
            'Status da moderação atualizado com sucesso!'
        );
    }
}
