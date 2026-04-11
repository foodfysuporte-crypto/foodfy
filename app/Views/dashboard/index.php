<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <?php $session = session() ?>
                    <h1 class="m-0 text-dark">Seja bem vindo!</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inicio</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Gráfico Fat. Anual</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chartjs-line" class="chartjs" width="undefined" height="undefined"></canvas>

                            <script>
                                new Chart(document.getElementById("chartjs-line"), {
                                    "type": "line",
                                    "data": {
                                        "labels": [
                                            <?php foreach ($nomes_meses as $nome) : ?> "<?= $nome ?>",
                                            <?php endforeach; ?>
                                        ],
                                        "datasets": [{
                                            "label": "Faturamento",
                                            "data": [
                                                <?php foreach ($faturamento_por_meses as $fat) : ?>
                                                    <?= $fat ?>,
                                                <?php endforeach; ?>
                                            ],
                                            "fill": false,
                                            "backgroundColor": ["#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56", "#660F56"],
                                            "borderColor": ["#660F56"],
                                            "borderWidth": 3
                                        }]
                                    },
                                    "options": {
                                        "scales": {
                                            "yAxes": [{
                                                "ticks": {
                                                    "beginAtZero": true
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-4 col-6">

                            <div class="small-box bg-info" style="background-color: #9032BB !important;">
                                <div class="inner">
                                    <h3><?= $qtde_mesas ?></h3>
                                    <p>Mesas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="/mesas" class="small-box-footer">Acessar <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">

                            <div class="small-box bg-success" style="background-color: #9032BB !important;">
                                <div class="inner">
                                    <h3><?= $qtde_produtos ?></h3>
                                    <p>Produtos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <a href="/produtos" class="small-box-footer">Acessar <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">

                            <div class="small-box bg-warning" style="background-color: #9032BB !important; color: white !important">
                                <div class="inner">
                                    <h3><?= $qtde_entregas ?></h3>
                                    <p>Entregas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <a href="/vendas" class="small-box-footer" style="color: white !important">Acessar <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">

                            <div class="small-box bg-danger" style="background-color: #9032BB !important;">
                                <div class="inner">
                                    <h3><?= $qtde_lancamentos ?></h3>
                                    <p>Lançamentos</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <a href="/lancamentos" class="small-box-footer">Acessar <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-primary" style="background-color: #9032BB !important;">
                                <div class="inner">
                                    <h3><?= number_format($faturamento, 2, ',', '.') ?></h3>
                                    <p>Faturamento</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-usd"></i>
                                </div>
                                <a href="/orcamentos" style="color: black" class="small-box-footer">Acessar <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-warning" style="background-color: #9032BB !important; color: white !important">
                                <div class="inner">
                                    <h3><?= number_format($total_despesas, 2, ',', '.') ?></h3>
                                    <p>Despesas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-list"></i>
                                </div>
                                <a href="#" class="small-box-footer">Acessar <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contas a Receber <?= date('m/Y') ?></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Nome</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($contas_receber)) : ?>
                                        <?php foreach ($contas_receber as $conta) : ?>
                                            <tr>
                                                <td><?= $conta['status'] ?></td>
                                                <td><?= $conta['nome'] ?></td>
                                                <td><?= $conta['data_de_vencimento'] ?></td>
                                                <td><?= number_format($conta['valor'], 2, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4">Nenhum registro!</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contas a Pagar <?= date('m/Y') ?></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Nome</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($contas_pagar)) : ?>
                                        <?php foreach ($contas_pagar as $conta) : ?>
                                            <tr>
                                                <td><?= $conta['status'] ?></td>
                                                <td><?= $conta['nome'] ?></td>
                                                <td><?= $conta['data_de_vencimento'] ?></td>
                                                <td><?= number_format($conta['valor'], 2, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4">Nenhum registro!</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->