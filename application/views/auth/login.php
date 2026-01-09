<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo getInfoRS('nama_apps')?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/adminlte/plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
        <style>
            :root {
                --primary: #1b6cc5;
                --dark: #0f2847;
                --soft: #e8f2ff;
            }
            * { font-family: 'Poppins', 'Source Sans Pro', system-ui, sans-serif; }
            body {
                min-height: 100vh;
                background: radial-gradient(circle at 20% 20%, rgba(27,108,197,0.15), transparent 30%),
                            radial-gradient(circle at 80% 0%, rgba(15,40,71,0.25), transparent 35%),
                            linear-gradient(120deg, #0f2847 0%, #123a64 40%, #0f2847 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 30px 15px;
            }
            .auth-shell {
                width: 25%;
                max-width: 960px;
                background: rgba(255,255,255,0.08);
                border: 1px solid rgba(255,255,255,0.12);
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.28);
                overflow: hidden;
                backdrop-filter: blur(10px);
            }
            .auth-row {
                display: flex;
                flex-wrap: wrap;
            }
            .auth-visual {
                flex: 1 1 45%;
                min-height: 320px;
                background: linear-gradient(160deg, #1b6cc5, #0f2847);
                color: #fff;
                padding: 32px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .auth-visual .tag {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 999px;
                background: rgba(255,255,255,0.14);
                border: 1px solid rgba(255,255,255,0.3);
                letter-spacing: 0.5px;
                font-weight: 600;
            }
            .auth-visual h1 {
                font-weight: 700;
                margin: 18px 0 10px;
                line-height: 1.2;
            }
            .auth-visual p {
                opacity: 0.9;
                margin-bottom: 0;
            }
            .auth-form {
                flex: 1 1 55%;
                background: #f8fbff;
                padding: 36px;
            }
            .brand {
                text-align: center;
                margin-bottom: 24px;
            }
            .brand img {
                width: 92px;
                height: 92px;
                object-fit: contain;
                border-radius: 18px;
                box-shadow: 0 10px 30px rgba(27,108,197,0.28);
            }
            .brand .name {
                margin-top: 12px;
                font-size: 20px;
                font-weight: 700;
                color: #0f2847;
            }
            .login-box-msg {
                text-align: center;
                margin-bottom: 20px;
                color: #304661;
            }
            .form-control {
                height: 46px;
                border-radius: 12px;
                border: 1px solid #d6e2f1;
                box-shadow: none;
            }
            .input-group-addon {
                border-radius: 12px 0 0 12px;
                background: #f0f5ff;
                color: #1b6cc5;
                border-color: #d6e2f1;
            }
            .btn-primary {
                background: linear-gradient(135deg, #1b6cc5, #0f2847);
                border: none;
                border-radius: 12px;
                font-weight: 600;
                box-shadow: 0 10px 25px rgba(27,108,197,0.35);
                transition: transform 0.15s ease, box-shadow 0.15s ease;
            }
            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 14px 30px rgba(27,108,197,0.4);
            }
            .footer-meta {
                margin-top: 18px;
                text-align: center;
                color: #70839b;
                font-size: 13px;
            }
            @media (max-width: 768px) {
                body { padding: 20px 10px; }
                .auth-row { flex-direction: column; }
                .auth-visual { min-height: 200px; }
            }
        </style>
    </head>
    <body class="hold-transition">
        <?php
        $uploadedLogo = getInfoRS('logo');
        $logoPath = 'assets/foto_profil/' . ($uploadedLogo ? $uploadedLogo : 'logo2.png');
        if ($uploadedLogo && !file_exists(FCPATH . $logoPath)) {
            $logoPath = 'assets/foto_profil/logo2.png';
        }
        $status_login = $this->session->userdata('status_login');
        $message = empty($status_login) ? 'Silahkan login untuk masuk ke aplikasi' : $status_login;
        ?>

        <div class="auth-shell">
            <div class="auth-row">

                <div class="auth-form">
                    <div class="brand">
                        <img src="<?php echo base_url($logoPath); ?>" alt="Logo">
                        <div class="name"><?php echo getInfoRS('nama_apps'); ?></div>
                    </div>
                    <p class="login-box-msg"><?php echo $message; ?></p>

                    <?php echo form_open('auth/cheklogin'); ?>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-sign-in"></i> Masuk</button>
                    <?php echo form_close(); ?>

                    <div class="footer-meta">
                        © <?php echo date('Y'); ?> <?php echo getInfoRS('nama_apps'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery 3 -->
        <script src="<?php echo base_url(); ?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(); ?>/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(); ?>/assets/adminlte/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
