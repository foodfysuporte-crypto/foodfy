<?php
$session = session();

function renderPermissionSelect($name, $label, $selectedData) {
    // Some keys might be different in the DB, but they are passed as $name here
    $val = (isset($selectedData) && isset($selectedData[$name]) && $selectedData[$name] == 1) ? 1 : 0;
    if (!isset($selectedData)) $val = 1; // Default Sim for new users
    ?>
    <div class="col-lg-6 mb-3">
        <label class="text-muted small text-uppercase font-weight-bold" style="letter-spacing: 1px; display: block; margin-bottom: 5px;"><?= $label ?></label>
        <select class="form-control select2 custom-select-premium" id="<?= $name ?>" name="<?= $name ?>" style="width: 100%; border-radius: 8px; border: 1px solid #e0e0e0;">
            <option value="1" <?= $val == 1 ? 'selected' : '' ?>>Sim</option>
            <option value="0" <?= $val == 0 ? 'selected' : '' ?>>Não</option>
        </select>
    </div>
    <?php
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0" style="font-weight: 700; color: #333;">Acessos do Usu&aacute;rio</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="/login/usuarios" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="/login/store" method="post">
                
                <!-- CARD INFORMAÇÕES BÁSICAS -->
                <div class="card shadow-lg mb-4" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 font-weight-bold" style="color: #660F56">
                            <i class="fas fa-user-circle mr-2"></i> Dados de Acesso
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="usuario">Usu&aacute;rio</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?= (isset($usuario)) ? $usuario['usuario'] : "" ?>" required onblur="verificaNomeDeUsuario()" style="border-radius: 8px;">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="senha">Senha</label>
                                    <input type="password" class="form-control" id="senha" name="senha" value="<?= (isset($usuario)) ? $usuario['senha'] : "" ?>" required style="border-radius: 8px;">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="tipo">N&iacute;vel de Acesso</label>
                                    <select class="form-control select2" id="tipo" name="tipo" style="width: 100%; border-radius: 8px;">
                                        <?php if (isset($usuario)): ?>
                                            <option value="1" <?= ($usuario['tipo'] == 1) ? "selected" : "" ?>>Admin</option>
                                            <option value="2" <?= ($usuario['tipo'] == 2) ? "selected" : "" ?>>Comum</option>
                                        <?php else: ?>
                                            <option value="1">Admin</option>
                                            <option value="2" selected>Comum</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="id_funcionario">Funcion&aacute;rio Vinculado</label>
                                    <select class="form-control select2" id="id_funcionario" name="id_funcionario" style="width: 100%; border-radius: 8px;">
                                        <option value="">Nenhum (Apenas Admin)</option>
                                        <?php foreach ($funcionarios as $func): ?>
                                            <?php 
                                                $selected = "";
                                                if (isset($usuario) && $usuario['id_funcionario'] == $func['id_funcionario']) $selected = "selected";
                                                if (!isset($usuario) && isset($id_funcionario_pre_selecionado) && $id_funcionario_pre_selecionado == $func['id_funcionario']) $selected = "selected";
                                            ?>
                                            <option value="<?= $func['id_funcionario'] ?>" <?= $selected ?>><?= $func['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABS DE PERMISSÕES -->
                <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-white p-0 border-0">
                        <ul class="nav nav-tabs p-2" id="permissionTabs" role="tablist" style="background: #fdfdfd; border-bottom: 2px solid #f1f1f1;">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-vendas-tab" data-toggle="pill" href="#tab-vendas" role="tab" aria-selected="true">🛒 Vendas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-food-tab" data-toggle="pill" href="#tab-food" role="tab">🍕 Food</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-geral-tab" data-toggle="pill" href="#tab-geral" role="tab">📦 Estoque/Geral</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-financeiro-tab" data-toggle="pill" href="#tab-financeiro" role="tab">💰 Financeiro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-fiscal-tab" data-toggle="pill" href="#tab-fiscal" role="tab">🧾 Fiscal/Relatórios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-outros-tab" data-toggle="pill" href="#tab-outros" role="tab">⚙️ Outros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-dashboard-tab" data-toggle="pill" href="#tab-dashboard" role="tab">📊 Dashboard</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="tab-content" id="permissionTabsContent">
                            
                            <!-- TAB VENDAS -->
                            <div class="tab-pane fade show active" id="tab-vendas" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Operações de Venda</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_vendas" name="modulo_vendas" checked onclick="desabilitaModuloVendas()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_vendas">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php 
                                    $data = isset($controle_de_acesso_do_usuario_selecionado) ? $controle_de_acesso_do_usuario_selecionado : null;
                                    renderPermissionSelect('venda_rapida', 'Venda Rápida', $data);
                                    renderPermissionSelect('pesquisa_produto', 'Pesquisa Produto', $data);
                                    renderPermissionSelect('historico_de_vendas', 'Histórico de Vendas', $data);
                                    renderPermissionSelect('orcamentos', 'Orçamentos', $data);
                                    renderPermissionSelect('pedidos', 'Pedidos', $data);
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Ordem de Serviço</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_ordem_de_servico" name="modulo_ordem_de_servico" checked onclick="desabilitaModuloOrdemDeServico()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_ordem_de_servico">Ativar Módulo</label>
                                        </div>
                                    </div>
                                    <?php renderPermissionSelect('ordem_de_servico', 'Acesso O.S.', $data); ?>
                                </div>
                            </div>

                            <!-- TAB FOOD -->
                            <div class="tab-pane fade" id="tab-food" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-warning" style="color: #e67e22 !important">Módulo Gastronomia (Food)</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_food" name="modulo_food" checked onclick="desabilitaModuloFood()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_food">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('novo_pedido', 'Novo Pedido', $data);
                                    renderPermissionSelect('mesas', 'Gestão de Mesas', $data);
                                    renderPermissionSelect('entregas', 'Entregas (Delivery)', $data);
                                    renderPermissionSelect('abrir_painel', 'Abrir Painel', $data);
                                    renderPermissionSelect('transmitir_no_painel', 'Transmitir no Painel', $data);
                                    renderPermissionSelect('configs', 'Configurações Food', $data);
                                    ?>
                                </div>
                            </div>

                            <!-- TAB ESTOQUE/GERAL -->
                            <div class="tab-pane fade" id="tab-geral" role="tabpanel">
                                <div class="row mb-4">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-success">Controle Geral</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_controle_geral" name="modulo_controle_geral" checked onclick="DesabilitaModuloControleGeral()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_controle_geral">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('clientes', 'Clientes', $data);
                                    renderPermissionSelect('fornecedores', 'Fornecedores', $data);
                                    renderPermissionSelect('funcionarios', 'Funcionários', $data);
                                    renderPermissionSelect('vendedores', 'Vendedores', $data);
                                    renderPermissionSelect('entregadores', 'Entregadores', $data);
                                    renderPermissionSelect('tecnicos', 'Técnicos', $data);
                                    renderPermissionSelect('servico_mao_de_obra', 'Serviço/Mão de Obra', $data);
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-success">Estoque e Produtos</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_estoque" name="modulo_estoque" checked onclick="DesabilitaModuloEstoque()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_estoque">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('produtos', 'Produtos', $data);
                                    renderPermissionSelect('reposicoes', 'Reposições', $data);
                                    renderPermissionSelect('saida_de_mercadorias', 'Saída de Mercadorias', $data);
                                    renderPermissionSelect('inventario_do_estoque', 'Inventário', $data);
                                    renderPermissionSelect('categoria_dos_produtos', 'Categorias', $data);
                                    ?>
                                </div>
                            </div>

                            <!-- TAB FINANCEIRO -->
                            <div class="tab-pane fade" id="tab-financeiro" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-info">Gestão Financeira</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_financeiro" name="modulo_financeiro" checked onclick="DesabilitaModuloFinanceiro()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_financeiro">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('caixas', 'Controle de Caixas', $data);
                                    renderPermissionSelect('lancamentos', 'Lançamentos', $data);
                                    renderPermissionSelect('retiradas_do_caixa', 'Retiradas (Sangria)', $data);
                                    renderPermissionSelect('despesas', 'Despesas', $data);
                                    renderPermissionSelect('contas_a_pagar', 'Contas a Pagar', $data);
                                    renderPermissionSelect('contas_a_receber', 'Contas a Receber', $data);
                                    renderPermissionSelect('relatorio_dre', 'DRE', $data);
                                    ?>
                                </div>
                            </div>

                            <!-- TAB FISCAL / RELATORIOS -->
                            <div class="tab-pane fade" id="tab-fiscal" role="tabpanel">
                                <div class="row mb-4">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-danger">Controle Fiscal</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_controle_fiscal" name="modulo_controle_fiscal" checked onclick="DesabilitaModuloControleFiscal()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_controle_fiscal">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('nfe', 'NFe (Nota Fiscal Eletrônica)', $data);
                                    renderPermissionSelect('nfce', 'NFCe (Cupom Fiscal)', $data);
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-danger">Central de Relatórios</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_relatorios" name="modulo_relatorios" checked onclick="DesabilitaModuloRelatorios()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_relatorios">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('vendas_historico_completo', 'Historico Vendas', $data);
                                    renderPermissionSelect('vendas_por_cliente', 'Vendas por Cliente', $data);
                                    renderPermissionSelect('vendas_por_vendedor', 'Vendas por Vendedor', $data);
                                    renderPermissionSelect('estoque_produtos', 'Estoque de Produtos', $data);
                                    renderPermissionSelect('estoque_minimo', 'Estoque Mínimo', $data);
                                    renderPermissionSelect('financeiro_movimentacao_de_entradas_e_saidas', 'Mov. Entradas/Saídas', $data);
                                    renderPermissionSelect('financeiro_faturamento_diario', 'Faturamento Diário', $data);
                                    renderPermissionSelect('financeiro_faturamento_detalhado', 'Faturamento Detalhado', $data);
                                    ?>
                                </div>
                            </div>

                            <!-- TAB OUTROS -->
                            <div class="tab-pane fade" id="tab-outros" role="tabpanel">
                                <div class="row mb-3">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-secondary">Agenda</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_agenda" name="modulo_agenda" checked onclick="DesabilitaModuloAgenda()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_agenda">Ativar</label>
                                        </div>
                                    </div>
                                    <?php renderPermissionSelect('agenda', 'Acesso à Agenda', $data); ?>
                                </div>
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-secondary">Configurações Gerais</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="modulo_configuracoes" name="modulo_configuracoes" checked onclick="DesabilitaModuloConfiguracoes()">
                                            <label class="custom-control-label font-weight-bold" for="modulo_configuracoes">Ativar</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('usuarios', 'Usuários/Permissões', $data);
                                    renderPermissionSelect('config_da_conta', 'Minha Conta', $data);
                                    renderPermissionSelect('config_da_empresa', 'Minha Empresa', $data);
                                    renderPermissionSelect('config_nfe_e_nfce', 'Configs Fiscais', $data);
                                    ?>
                                </div>
                            </div>

                            <!-- TAB DASHBOARD -->
                            <div class="tab-pane fade" id="tab-dashboard" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 border-bottom pb-2 mb-3 d-flex align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-dark">Widgets do In&iacute;cio (Dashboard)</h6>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="resumo_dashboard_inicio" name="resumo_dashboard_inicio" checked onclick="DesabilitaResumoDashbaordInicio()">
                                            <label class="custom-control-label font-weight-bold" for="resumo_dashboard_inicio">Módulo Ativo</label>
                                        </div>
                                    </div>
                                    <?php
                                    renderPermissionSelect('widget_clientes', 'Widget Clientes', $data);
                                    renderPermissionSelect('widget_produtos', 'Widget Produtos', $data);
                                    renderPermissionSelect('widget_vendas', 'Widget Vendas', $data);
                                    renderPermissionSelect('widget_lancamentos', 'Widget Lançamentos', $data);
                                    renderPermissionSelect('widget_faturamento', 'Widget Faturamento', $data);
                                    renderPermissionSelect('widget_os', 'Widget O.S.', $data);
                                    renderPermissionSelect('grafico_faturamento_linha', 'Gráfico Linhas', $data);
                                    renderPermissionSelect('grafico_faturamento_barras', 'Gráfico Barras', $data);
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php if (isset($usuario) && isset($data)): ?>
                        <input type="hidden" name="id_login" value="<?=$usuario['id_login']?>">
                        <input type="hidden" name="id_controle_de_acesso" value="<?=$data['id_controle_de_acesso']?>">
                    <?php endif;?>

                    <div class="card-footer bg-light py-4 text-right">
                        <button type="submit" class="btn btn-primary shadow">
                            <i class="fas fa-save mr-2"></i> <?= (isset($usuario)) ? "Atualizar Permissões" : "Cadastrar Usuário" ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        border: none;
        color: #666;
        font-weight: 500;
        padding: 12px 20px;
        transition: all 0.2s;
        border-radius: 8px !important;
        margin: 0 4px;
    }
    .nav-tabs .nav-link.active {
        background: rgba(102, 15, 86, 0.1) !important;
        color: #660F56 !important;
        font-weight: 600;
    }
    .custom-select-premium {
        height: 45px !important;
        background-color: #fdfdfd !important;
    }
    .tab-pane {
        padding-top: 10px;
    }
</style>

<script>
    function desabilitaModuloVendas() {
        let status = !document.getElementById('modulo_vendas').checked;
        ['venda_rapida','pesquisa_produto','historico_de_vendas','orcamentos','pedidos'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function desabilitaModuloOrdemDeServico() {
        document.getElementById('ordem_de_servico').disabled = !document.getElementById('modulo_ordem_de_servico').checked;
    }

    function desabilitaModuloFood() {
        let status = !document.getElementById('modulo_food').checked;
        ['novo_pedido','mesas','entregas','abrir_painel','transmitir_no_painel','configs'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaModuloControleGeral() {
        let status = !document.getElementById('modulo_controle_geral').checked;
        ['clientes','fornecedores','funcionarios','vendedores','entregadores','tecnicos','servico_mao_de_obra'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaModuloEstoque() {
        let status = !document.getElementById('modulo_estoque').checked;
        ['produtos','reposicoes','saida_de_mercadorias','inventario_do_estoque','categoria_dos_produtos'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaModuloFinanceiro() {
        let status = !document.getElementById('modulo_financeiro').checked;
        ['caixas','lancamentos','retiradas_do_caixa','despesas','contas_a_pagar','contas_a_receber','relatorio_dre'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaModuloControleFiscal() {
        let status = !document.getElementById('modulo_controle_fiscal').checked;
        ['nfe','nfce'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaModuloRelatorios() {
        let status = !document.getElementById('modulo_relatorios').checked;
        ['vendas_historico_completo','vendas_por_cliente','vendas_por_vendedor','estoque_produtos','estoque_minimo','financeiro_movimentacao_de_entradas_e_saidas','financeiro_faturamento_diario','financeiro_faturamento_detalhado'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaModuloAgenda() {
        document.getElementById('agenda').disabled = !document.getElementById('modulo_agenda').checked;
    }

    function DesabilitaModuloConfiguracoes() {
        let status = !document.getElementById('modulo_configuracoes').checked;
        ['usuarios','config_da_conta','config_da_empresa','config_nfe_e_nfce'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    function DesabilitaResumoDashbaordInicio() {
        let status = !document.getElementById('resumo_dashboard_inicio').checked;
        ['widget_clientes','widget_produtos','widget_vendas','widget_lancamentos','widget_faturamento','widget_os','grafico_faturamento_linha','grafico_faturamento_barras'].forEach(id => {
            document.getElementById(id).disabled = status;
        });
    }

    $(function() {
        <?php if(isset($data)): ?>
            // Inicializar estados conforme DB
            // (A logica de PHP nos loops acima ja cuida dos checked se desejado, 
            // mas podemos forçar aqui se as funções de desabilitar forem complexas)
            desabilitaModuloVendas();
            desabilitaModuloOrdemDeServico();
            desabilitaModuloFood();
            DesabilitaModuloControleGeral();
            DesabilitaModuloEstoque();
            DesabilitaModuloFinanceiro();
            DesabilitaModuloControleFiscal();
            DesabilitaModuloRelatorios();
            DesabilitaModuloAgenda();
            DesabilitaModuloConfiguracoes();
            DesabilitaResumoDashbaordInicio();
        <?php endif; ?>
    });

    function verificaNomeDeUsuario() {
        var doc = document.getElementById('usuario');
        var usuario = doc.value;
        if(usuario != "<?= (isset($usuario)) ? $usuario['usuario'] : '' ?>") {
            $.post("/login/verificaNomeDeUsuario", { usuario: usuario }, function(data, status) {
                if (status == "success" && data == "1") {
                    alert('Esse usuário não pode ser cadastrado. Por favor, escolha outro.');
                    doc.value = "";
                    doc.focus();
                }
            });
        }
    }
</script>