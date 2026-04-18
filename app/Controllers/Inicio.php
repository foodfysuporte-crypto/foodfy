<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ContaPagarModel;
use App\Models\ContaReceberModel;
use App\Models\ControleDeAcessoModel;
use App\Models\DespesaModel;
use App\Models\EntregaModel;
use App\Models\LancamentoModel;
use App\Models\MesaModel;
use App\Models\OrcamentoModel;
use App\Models\ProdutoModel;
use App\Models\VendaModel;
use CodeIgniter\Controller;

class Inicio extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $despesa_model;
    private $entrega_model;
    private $mesa_model;
    private $cliente_model;
    private $produto_model;
    private $venda_model;
    private $lancamento_model;
    private $orcamento_model;
    private $conta_pagar_model;
    private $conta_receber_model;

    private $controle_de_acesso_model;

    function __construct()
    {
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');
        
        $this->despesa_model = new DespesaModel();
        $this->entrega_model = new EntregaModel();
        $this->mesa_model = new MesaModel();
        $this->cliente_model = new ClienteModel();
        $this->produto_model = new ProdutoModel();
        $this->venda_model = new VendaModel();
        $this->lancamento_model = new LancamentoModel();
        $this->orcamento_model = new OrcamentoModel();
        $this->conta_pagar_model = new ContaPagarModel();
        $this->conta_receber_model = new ContaReceberModel();

        $this->controle_de_acesso_model = new ControleDeAcessoModel();
    }

    public function index()
    {
        // Revifica se tem uma sessÃ£o ativa
        if($this->session->get('tipo') == null):
            $this->session->setFlashdata(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'VocÃª nÃ£o estÃ¡ logado! Acesse sua conta para continuar.'
                ]
            );

            return redirect()->to('/login');
        endif;

        $data['link'] = [
            'item' => '1'
        ];

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_login', $this->id_login)
                                                    ->first();

        $mesas = $this->mesa_model
                            ->where('id_empresa', $this->id_empresa)
                            ->findAll();

        $produtos = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $entregas = $this->entrega_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('data >=', date("Y-m-01"))
                            ->where('data <=', date("Y-m-t"))
                            ->findAll(); 

        $lancamentos = $this->lancamento_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $faturamento = 0;

        foreach($lancamentos as $lancamento)
        {
            $faturamento += $lancamento['valor'];
        }

        // ------------------------ DADOS MONTAGEM GRÃFICOS FATURAMENTO ANUAL ------------------------- //
        $nomes_meses = [
            'Jan',
            'Fev',
            'Mar',
            'Abr',
            'Mai',
            'Jun',
            'Jul',
            'Ago',
            'Set',
            'Out',
            'Nov',
            'Dez',
        ];

        $faturamento_por_meses = [];
        for($i = 1; $i <= 12; $i++)
        {
            $start_date = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01';
            $end_date = date('Y-m-t', strtotime($start_date));
            $valor = $this->lancamento_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('data >=', $start_date)
                            ->where('data <=', $end_date)
                            ->selectSum('valor')
                            ->first();

            if($valor['valor'] == null)
            {
                $faturamento_por_meses[] = 0;
            }
            else
            {
                $faturamento_por_meses[] = $valor['valor'];
            }
        }

        // ------------------------ CONTAS A PAGAR E RECEBER DO MES ATUAL ------------------------- //
        $contas_pagar = $this->conta_pagar_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('data_de_vencimento >=', date('Y-m-01'))
                                            ->where('data_de_vencimento <=', date('Y-m-t'))
                                            ->findAll();

        $contas_receber = $this->conta_receber_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('data_de_vencimento >=', date('Y-m-01'))
                                            ->where('data_de_vencimento <=', date('Y-m-t'))
                                            ->findAll();

        $despesas = $this->despesa_model
                                    ->findAll();

        $total_despesas = 0;
        foreach($despesas as $despesa)
        {
            $total_despesas += $despesa['valor'];
        }

        // ------------------------------------------------------- //                                    
        $data['qtde_mesas'] = count($mesas);
        $data['qtde_produtos'] = count($produtos);
        $data['qtde_entregas'] = count($entregas);
        $data['qtde_lancamentos'] = count($lancamentos);
        $data['qtde_orcamentos'] = 0;
        $data['faturamento'] = $faturamento;

        $data['nomes_meses'] = $nomes_meses;
        $data['faturamento_por_meses'] = $faturamento_por_meses;

        $data['contas_pagar'] = $contas_pagar;
        $data['contas_receber'] = $contas_receber;
        $data['total_despesas'] = $total_despesas;

        echo view('templates/header', $data);
        echo view('dashboard/index');
        echo view('templates/footer');
    }
}
