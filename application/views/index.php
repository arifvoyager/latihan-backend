<!DOCTYPE html>
<html lang="en">
  <head>
	<title><?php echo isset($META_TITLE) ? $META_TITLE : GET_COMPANY('general_meta'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <meta name="description" content="<?php echo isset($META_DESCRIPTION) ? $META_DESCRIPTION : GET_COMPANY('general_meta_description'); ?>">
    <meta name="author" content="">

    <meta property="og:url"           content="<?php echo base_url(); ?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="<?php echo isset($META_TITLE) ? $META_TITLE : GET_COMPANY('general_meta'); ?>" />
	<meta property="og:description"   content="<?php echo isset($META_DESCRIPTION) ? $META_DESCRIPTION : GET_COMPANY('general_meta_description'); ?>" />
      
    <!-- page specific plugin styles -->   
    <link href="<?php echo base_url('pubs/uploads/images/fi-favicon.png'); ?>" rel="shortcut icon" type="image/x-icon" />

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/bootstrap-3.3.4/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-3.3.4/font-awesome-4.3.0/css/font-awesome.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/styles/desktop.css'); ?>" rel="stylesheet" />
    <?php
        if ($this->agent->is_mobile == true) { 
            ?>
                <link href="<?php echo base_url('assets/styles/mobile.css'); ?>" rel="stylesheet" />
            <?php 
        }
    ?>
    <link href="<?php echo base_url('assets/styles/fonts.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url("assets/styles/flag-icon-css/flag-icon.css"); ?>" rel="stylesheet">
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <link href="<?php echo base_url('assets/jquery/blitzer/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
    <script src="<?php echo base_url('assets/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jquery/jquery-ui.js'); ?>"></script>

    <script type="text/javascript">
        var BASE_URL        = '<?php echo base_url(); ?>';  
        var CURRENT_PATH 	= window.location.href;  
    (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.8";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    
    </script>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111924972-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-111924972-1');
    </script>
</head>

<body>
    <?php
        $sURL = urlencode(
            'http' .
            ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://' .
            $_SERVER['HTTP_HOST'] .
            $_SERVER['PHP_SELF']
        );
    ?>
    
    
    <div class="container-fluid no-padding">
        <!-- FOR HEADER -->
        <?php echo $this->load->view("layout/header.php"); ?>

        <div id='content'>
            <?php
            if (isset($content) AND $content != NULL) {
                include $content;
            } else {
                include "page_404.php";
            }
            ?>
        </div>

        <!-- FOR FOOTER -->
        <?php echo $this->load->view("layout/footer.php"); ?>
    </div>
    
    <?php
        //echo $GET_COMPANY->setting_ga;
    ?>
    <div id='ajax_loader'></div>

    <script src="<?php echo base_url('assets/bootstrap-3.3.4/js/bootstrap.min.js'); ?>"></script>

    <!-- Global function -->
    <script src="<?php echo base_url('assets/global_function.js'); ?>"></script>

    <script type="text/javascript">
        jQuery(function ($){
            $(document).ajaxStop(function(){
                $("#ajax_loader").hide();
             });
             $(document).ajaxStart(function(){
                 $("#ajax_loader").show();
             });    
        });            
        //- SCROOL TO TOP ------------------------------------------------------------------------------------------
        jQuery(document).ready(function($){
            // browser window scroll (in pixels) after which the "back to top" link is shown
            var offset = 100,
                //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
                offset_opacity = 1200,
                //duration of the top scrolling animation (in ms)
                scroll_top_duration = 700,
                //grab the "back to top" link
                $back_to_top = $('.cd-top');

            //hide or show the "back to top" link
            $(window).scroll(function(){
                ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
                if( $(this).scrollTop() > offset_opacity ) { 
                    $back_to_top.addClass('cd-fade-out');
                }
            });

            //smooth scroll to top
            $back_to_top.on('click', function(event){
                event.preventDefault();
                $('body,html').animate({
                    scrollTop: 0 ,
                    }, scroll_top_duration
                );
            });
        });
    </script>
</body>
</html>