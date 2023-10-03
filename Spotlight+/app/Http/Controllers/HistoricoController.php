<?php

namespace App\Http\Controllers;

use App\Models\HistoricoVisualizacao;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class HistoricoController extends Controller
{


    public function limparHistorico()
    {
        $userId = auth()->id();

        // Exclua todos os registros de histórico para o usuário
        HistoricoVisualizacao::where('user_id', $userId)->delete();

        return redirect()->back()->with('success', 'Histórico limpo com sucesso');
    }
    public function removerSelecionados(Request $request)
    {
        $userId = auth()->id();
        $itensSelecionados = $request->input('itens_selecionados',[]);
    
        // Verifique se há itens selecionados
        if (count($itensSelecionados) === 0) {
            return redirect()->back()->with('error', 'Nenhum item selecionado para remover');
        }
    
        // Exclua os registros de histórico correspondentes aos itens selecionados
        HistoricoVisualizacao::where('user_id', $userId)
            ->whereIn('media_id', $itensSelecionados)
            ->delete();
    
        return redirect()->back()->with('success', 'Itens selecionados removidos com sucesso');
    }

}


