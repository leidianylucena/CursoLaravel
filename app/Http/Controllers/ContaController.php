<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use Illuminate\Http\Request;
use App\Models\Conta;
use Exception;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;


class ContaController extends Controller
{
    // listar as contas
    public function index(Request $request)
    {
        // recuperar os registros do banco de dados
        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request){
            $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
        ->when($request->filled('data_inicio'), function ($whenQuery) use ($request){
            $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
        })
        ->when($request->filled('data_fim'), function ($whenQuery) use ($request){
            $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
        })
        ->orderBy('created_at', 'ASC')
        ->paginate(10)
        ->WithQueryString();


        // carregar a view
        return view('contas.index', [
            'contas' => $contas,
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
        ]);
    }

        // carregar o formulario cadastrar nova conta

    public function create()
    {
        return view('contas.create');

    }

        // cadastrar no banco de dados nova conta

    public function store(ContaRequest $request)
    {    // validar o formulario
        $request->validated();

        try {

        // cadastrar no banco de dados na tabela contas os valores de todos os campos
        $conta = Conta::create([
            'nome' => $request->nome,
            'valor' => str_replace(',', '.', str_replace('.', '', $request->valor)),
            'vencimento' => $request->vencimento
    ]);

        // redirecionar o usuario, enviar a mensagem de sucesso
        return redirect()->route('conta.show',[ 'conta' => $conta->id ])->with('success', 'Conta cadastrada com sucesso');

    }   catch (Exception $e) {
        Log::warning('Conta não cadastrada', ['error' => $e->getMessage()]);
        return back()->withInput()->with('error', 'Conta não cadastrada!');
    }
}

        // detalhes da conta

    public function show(Conta $conta)
    {

        return view('contas.show', ['conta' => $conta]);
    }

          // carregar o formulario cadastrar nova conta

    public function edit(Conta $conta)
    {
        return view('contas.edit', ['conta' => $conta]);
    }

        // editar no banco de dados a conta

    public function update(ContaRequest $request, Conta $conta)
    {
        $request->validated();

        try {

            $conta->update([
                'nome' => $request->nome,
                'valor' => str_replace(',', '.', str_replace(',', '', $request->valor)),
                'vencimento' => $request->vencimento,
        ]);

        // salvar log
        Log::info('Conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta ]);

            return redirect()->route('conta.show',[ 'conta' => $conta->id ])->with('success', 'Conta atualizada com sucesso');

        }   catch (Exception $e) {
                Log::warning('Conta não editada', ['error' => $e]);
                return back()->withInput()->with('error', 'Conta não editada!');
        }
    }

        // excluir a conta do banco de dados
    public function destroy(Conta $conta)
    {
        // excluir o registro do banco de dados
        $conta->delete();

        return redirect()->route('conta.index')->with('success', 'Conta apagada com sucesso');
    }
    public function gerarPdf(Request $request){
        //$contas = Conta::orderByDesc('created_at')->get();
        //return view('contas.gerar-pdf');

        // recuperar os registros do banco de dados
        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request){
            $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
        ->when($request->filled('data_inicio'), function ($whenQuery) use ($request){
            $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
        })
        ->when($request->filled('data_fim'), function ($whenQuery) use ($request){
            $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
        })
        ->orderBy('created_at', 'ASC')
        ->get();

        // Calcular a soma total dos valores
        $totalValor = $contas->sum('valor');

        $pdf = PDF::loadView('contas.gerar-pdf', [
            'contas' => $contas,
            'totalValor' =>$totalValor
            ])->setPaper('a4', 'portrait');
        return $pdf->download('listar_contas.pdf');


    }
    // Alterar situação da conta
    public function changeSituation(Conta $conta){

        try{

            // Editar as informações do registro no banco de dados
            $conta->update([
                'situacao_conta_id' => 1,
            ]);

            // salvar log
            Log::info('Situação da conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta ]);

            return back()->with('success', 'Situação da conta atualizada com sucesso!');

        } catch( Exception $e){
            Log::warning('Situação da conta não editada', ['error' => $e->getMessage()]);
            return back()->with('error', 'Situação da conta não editada!');
        }
    }

}



