<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Forgot password | Remark Admin Template</title>

  <link rel="apple-touch-icon" href="<?php echo base_url("assets/assets/backend/images/apple-touch-icon.png"); ?>">
  <link rel="shortcut icon" href="<?php echo base_url("assets/backend/images/favicon.ico"); ?>">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/bootstrap.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/bootstrap-extend.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/site.min.css"); ?>">

  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/animsition/animsition.css"); ?>">


  <!-- Page -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/pages/login.css"); ?>">
    
  <!-- Plugin -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/nprogress/nprogress.css"); ?>">

  <!-- Fonts -->
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>


  <!--[if lt IE 9]>
    <script src="<?php echo base_url("assets/backend/vendor/html5shiv/html5shiv.min.js"); ?>"></script>
    <![endif]-->

  <!--[if lt IE 10]>
    <script src="<?php echo base_url("assets/backend/vendor/media-match/media.match.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/backend/vendor/respond/respond.min.js"); ?>"></script>
    <![endif]-->

  <!-- Scripts -->
  <script src="<?php echo base_url("assets/backend/vendor/modernizr/modernizr.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/breakpoints/breakpoints.js"); ?>"></script>
  <script>
      Breakpoints();
      var BASE_URL  = '<?php echo base_url(); ?>';
      var pathname 	= window.location.href;
  </script>
</head>
<body class="page-forgot-password layout-full">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


  <!-- Page -->
  <div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <h2 class="page-title">Forgot Your Password ?</h2>
      <p>Input your registered email to reset your password</p>

      <form class="width-300 margin-top-30 center-block" method="post" name="frm_request_passwd" action="<?php echo base_url('jpanel/cpanelx/requestpaswd'); ?>">
        <div class="form-group">
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Your Email">
        </div>
        <div class="form-group">
          <button type="button" onclick="getPasswd()" class="btn btn-primary btn-block">Reset Your Password</button>
        </div>
      </form>

      <footer class="page-copyright">
        <p>© 2015. Jawata System.</p>
      </footer>
    </div>
  </div>
  <!-- End Page -->

  <!-- Core  -->
  <script src="<?php echo base_url("assets/backend/vendor/jquery/jquery.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/bootstrap/bootstrap.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/animsition/jquery.animsition.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/asscroll/jquery-asScroll.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/mousewheel/jquery.mousewheel.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/asscrollable/jquery.asScrollable.all.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/ashoverscroll/jquery-asHoverScroll.js"); ?>"></script>

  <!-- Plugins -->
  <script src="<?php echo base_url("assets/backend/vendor/switchery/switchery.min.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/intro-js/intro.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/screenfull/screenfull.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/slidepanel/jquery-slidePanel.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/nprogress/nprogress.js"); ?>"></script>

  <script src="<?php echo base_url("assets/backend/vendor/jquery-placeholder/jquery.placeholder.js"); ?>"></script>

  <!-- Scripts -->
  <script src="<?php echo base_url("assets/backend/js/core.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/site.js"); ?>"></script>

  <script src="<?php echo base_url("assets/backend/js/sections/menu.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/sections/menubar.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/sections/sidebar.js"); ?>"></script>

  <script src="<?php echo base_url("assets/backend/js/configs/config-colors.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/configs/config-tour.js"); ?>"></script>

  <script src="<?php echo base_url("assets/backend/js/components/asscrollable.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/animsition.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/jquery-placeholder.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/nprogress.js"); ?>"></script>


    <script type="text/javascript">
      (function(document, window, $) {
          'use strict';
          
          var Site = window.Site;
          
          $(document).ready(function() {
              Site.run();
          });
          
      })(document, window, jQuery);
      
      function getPasswd() {
          var EMAIL = $('#inputEmail').val();
          
          if(EMAIL != '') {
              NProgress.start();
              $.ajax({
                url : BASE_URL + 'backend/cpanelx/requestpaswd',
                type: 'POST',
                data: { 
                    EMAIL : EMAIL
                },
                success: function (response) {
                    console.log(response);
                    if(response == 'success') {
                        NProgress.done(true);
                        alert('Please check your email');
                        window.location = BASE_URL + 'backend/cpanelx';
                        
                    } else {
                        NProgress.done(true);
                        alert('Email not registered');
                    }

                }
            });
              
          } else {
              alert('Please fill email form');
          }
      }
  </script>

</body>

</html>