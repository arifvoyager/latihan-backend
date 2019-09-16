<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">

    <title>Login | Jawata Panel Dashboard Management</title>

    <link rel="apple-touch-icon" href="<?php echo base_url("assets/assets/backend/images/apple-touch-icon.png"); ?>">
    <link rel="shortcut icon" href="<?php echo base_url("assets/backend/images/favicon.ico"); ?>">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/bootstrap-extend.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/site.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/custome.site.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.4/font-awesome-4.3.0/css/font-awesome.min.css'); ?>" />


    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/pages/login.css"); ?>">

    <!-- Plugin -->
    <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/nprogress/nprogress.css"); ?>">

    <!-- Fonts -->
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <script>
        var BASE_URL  = '<?php echo base_url(); ?>';
        var pathname 	= window.location.href;
    </script>
</head>
<body class="page-login layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
        <div class="page-content vertical-align-middle page-login-form">
            <div class="brand">
                <img class="brand-img" src="<?php echo base_url("assets/backend/images/logo-jawata.png"); ?>" alt="...">
                <h2 class="brand-text">dwPanel</h2>
            </div>
            <p>Sign into your pages account</p>
            
            <form method="post" action="#" name="formlogin" onsubmit="authLogin()">
                <div class="form-group input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input autocomplete="off" type="text" class="form-control" id="INPUT_USERNAME" placeholder="Username" name="username">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="INPUT_PASSWRD" name="password" placeholder="Password">
                </div>
                <div class="form-group clearfix">
                    <div class="checkbox-custom checkbox-inline pull-left">
                    </div>
                    <a class="pull-right" href="<?php echo base_url("jpanel/cpanelx/resetpassword"); ?>">Forgot password?</a>
                </div>
                <button type="button" onclick="authLogin()" class="btn btn-primary btn-block">
                    <i class="fa fa-sign-in"></i>
                    Sign in
                </button>
            </form>

            <footer class="page-copyright">
            <p>© 2015 dwPanel Ver 3.0.</p>
            </footer>
        </div>
    </div>
    <!-- End Page -->


  <!-- Core  -->
  <script src="<?php echo base_url("assets/backend/vendor/jquery/jquery.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/bootstrap/bootstrap.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/animsition/jquery.animsition.js"); ?>"></script>

  <!-- Plugins -->
  <script src="<?php echo base_url("assets/backend/vendor/nprogress/nprogress.js"); ?>"></script>

  <script src="<?php echo base_url("assets/backend/vendor/jquery-placeholder/jquery.placeholder.js"); ?>"></script>

  <!-- Scripts -->
  <script src="<?php echo base_url("assets/backend/js/core.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/animsition.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/jquery-placeholder.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/nprogress.js"); ?>"></script>

  <script type="text/javascript">
      
    $( "#INPUT_PASSWRD" ).keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);

        if(keycode == '13') {
            authLogin();
        }
    });
      
      function authLogin() {
          var USERNAME = $('#INPUT_USERNAME').val();
          var PASSWORD = $('#INPUT_PASSWRD').val();
          
          if(USERNAME != '' && PASSWORD != '') {
              NProgress.start();
              $.ajax({
                url : BASE_URL + 'jpanel/cpanelx/auth',
                type: 'POST',
                data: { 
                    USERNAME : USERNAME, 
                    PASSWORD : PASSWORD
                },
                success: function (response) {
                    console.log(response);
                    
                    if(response == 'success') {
                        NProgress.done(true);
                        window.location = pathname;
                        
                    } else if(response == 'failed') {
                        NProgress.done(true);
                        alert('Data login not valid');
                        
                    } else {
                        NProgress.done(true);
                        alert('Account disabled');
                    }
                }
            });
              
          } else {
              alert('Please fill data login');
          }
      }
  </script>

</body>

</html>