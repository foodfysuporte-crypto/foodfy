<?php

$session = session();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $session->get('xApp'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/fontawesome-free/css/all.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/select2/css/select2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') ?>">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/icheck-bootstrap/icheck-bootstrap.css') ?>">
    <!-- pace-progress -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/pace-progress/themes/purple/pace-theme-flat-top.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('theme/dist/css/adminlte.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Google Font: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Outfit", sans-serif !important; }
        .content-wrapper { background-color: #f8f9fa !important; }
        .card { border: none !important; border-radius: 12px !important; box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important; }
        .card-header { background-color: #fff !important; border-bottom: 1px solid rgba(0,0,0,0.05) !important; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background: linear-gradient(135deg, #660F56 0%, #9b1b82 100%) !important; border: none !important; border-radius: 8px !important; padding: 10px 24px !important; font-weight: 500 !important; transition: all 0.3s ease !important; }
        .btn-primary:hover { transform: translateY(-2px) !important; box-shadow: 0 4px 12px rgba(102, 15, 86, 0.4) !important; }
    </style>
    <!-- Google Font: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif !important;
        }
        .content-wrapper {
            background-color: #f8f9fa !important;
        }
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
        }
        .card-header {
            background-color: #fff !important;
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
            border-radius: 12px 12px 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #660F56 0%, #9b1b82 100%) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(102, 15, 86, 0.4) !important;
        }
    </style>

    <!-- ========= Scripts com prioridade ============= -->
    <!-- jQuery -->
    <script src="<?= base_url('theme/plugins/jquery/jquery.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('theme/plugins/sweetalert2/sweetalert2.js') ?>"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="<?= base_url('theme/plugins/chart.js/Chart.min.js') ?>"></script>

    <!-- ========= IMPRESSÃO ========== -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/print.css') ?>" media="print" />

</head>

<body class="sidebar-mini text-sm layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <?php include 'navbar.php'; ?>

        <?php include 'sidebar.php'; ?>