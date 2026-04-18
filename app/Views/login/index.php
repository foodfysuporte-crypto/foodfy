<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= $configuracao['nome_do_app'] ?></title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/fontawesome-free/css/all.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') ?>">
    <!-- Bootstrap/AdminLTE basis -->
    <link rel="stylesheet" href="<?= base_url('theme/dist/css/adminlte.css') ?>">
    <!-- Google Font: Outfit (Premium) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body.login-page {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        /* Dark overlay to make glassmorphism pop if there's a background image */
        body.login-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.65); /* Escurece a imagem de fundo levemente */
            z-index: 0;
        }

        .login-box {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 28px;
            padding: 40px 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-title {
            text-align: center;
            margin-bottom: 5px;
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            text-align: center;
            color: #94a3b8;
            font-weight: 300;
            font-size: 1.05rem;
            margin-bottom: 35px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group .fas {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: #cbd5e1;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .modern-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05) !important;
            border: 2px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px !important;
            height: 56px !important;
            padding: 10px 20px 10px 50px !important;
            color: #fff !important;
            font-size: 1.05rem;
            transition: all 0.3s ease !important;
            box-shadow: none !important;
        }

        .modern-input::placeholder {
            color: #64748b !important;
        }

        .modern-input:focus {
            border-color: #FF8E53 !important;
            background: rgba(255, 255, 255, 0.1) !important;
            outline: none;
        }

        .modern-input:focus + .fas {
            color: #FF8E53;
        }

        .btn-modern {
            width: 100%;
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            border: none;
            border-radius: 16px;
            height: 56px;
            color: white;
            font-size: 1.15rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px -10px rgba(255, 107, 107, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px -10px rgba(255, 107, 107, 0.8);
            color: white;
        }

        /* Removendo fundos brancos do autofill que estragam o design */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #1e293b inset !important;
            -webkit-text-fill-color: white !important;
        }
    </style>

    <!-- ========= Scripts com prioridade ============= -->
    <!-- jQuery -->
    <script src="<?= base_url('theme/plugins/jquery/jquery.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('theme/plugins/sweetalert2/sweetalert2.js') ?>"></script>
</head>

<?php if ($configuracao['arquivo-imagem-de-fundo-login'] != "") : ?>
    <body class="hold-transition login-page" style="background-image: url('<?= base_url('assets/img') . "/" . $configuracao['arquivo-imagem-de-fundo-login'] ?>');">
<?php else : ?>
    <body class="hold-transition login-page">
<?php endif; ?>

    <div class="login-box">
        <div class="glass-card">
            
            <div class="login-title">
                <?= $configuracao['nome_do_app'] ?>
            </div>
            <div class="login-subtitle">
                Acesse sua conta para continuar
            </div>

            <form action="<?= base_url('/login/autenticar') ?>" method="post">
                
                <div class="form-group">
                    <input type="text" class="modern-input" name="usuario" placeholder="Nome de usuário" autofocus required>
                    <i class="fas fa-user"></i>
                </div>

                <div class="form-group">
                    <input type="password" class="modern-input" name="senha" placeholder="Sua senha" required>
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit" class="btn-modern">
                    Acessar o Painel
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

        </div>
    </div>

    <!-- Bootstrap 4 -->
    <script src="<?= base_url('theme/plugins/bootstrap/js/bootstrap.bundle.js') ?>"></script>
    <script>
        $(function() {
            // -------------- ALERTAS DO SISTEMA ---------------- //
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                background: '#1e293b',
                color: '#fff'
            });

            <?php
            $session = session();
            $alert = $session->getFlashdata('alert');

            if (isset($alert)) : ?>
                Toast.fire({
                    icon: '<?= ($alert['type'] == 'error') ? 'error' : 'success' ?>',
                    title: '<?= $alert['title'] ?>'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
