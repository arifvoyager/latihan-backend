<!DOCTYPE html>
<html class="no-js before-run" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">

  <title>Dashboard | Jawata Panel Dashboard Management</title>

  <link rel="apple-touch-icon" href="<?php echo base_url("assets/backend/images/apple-touch-icon.png"); ?>">
  <link rel="shortcut icon" href="<?php echo base_url("assets/backend/images/favicon.ico"); ?>">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/bootstrap.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/bootstrap-extend.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/site.min.css"); ?>">

  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/animsition/animsition.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/asscrollable/asScrollable.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/switchery/switchery.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/intro-js/introjs.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/slidepanel/slidePanel.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/flag-icon-css/flag-icon.css"); ?>">

  <!-- Plugin -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/select2/select2.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/bootstrap-table/bootstrap-table.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/bootstrap-select/bootstrap-select.css"); ?>">
    
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/bootstrap-sweetalert/sweet-alert.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/toastr/toastr.css"); ?>">

  <!-- Page -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/css/dashboard/v2.css"); ?>">

  <!-- Fonts -->
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/fonts/web-icons/web-icons.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/fonts/brand-icons/brand-icons.min.css"); ?>">
  <link rel="stylesheet" href="<?php echo base_url("assets/backend/fonts/font-awesome/font-awesome.css"); ?>">
<!--  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>-->


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
  <script type="text/javascript">
      Breakpoints();
      var BASE_URL  = '<?php echo base_url(); ?>';
      var pathname 	= window.location.href; 
  </script>

</head>
<body class="dashboard">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

  <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
      data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
      data-toggle="collapse">
        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
      </button>
      <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search"
      data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon wb-search" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle">
        <img class="navbar-brand-logo" src="<?php echo base_url("assets/backend/images/logo-jawata.png"); ?>" title="Jawata Admin">
        <span class="navbar-brand-text"> dwpanel</span>
      </div>
    </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="hidden-float" id="toggleMenubar">
            <a data-toggle="menubar" href="#" role="button">
              <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
            </a>
          </li>
          <li class="hidden-xs" id="toggleFullscreen">
            <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
              <span class="sr-only">Toggle fullscreen</span>
            </a>
          </li>
        </ul>
        <!-- End Navbar Toolbar -->

        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            
          <li>
            <a href="<?php echo base_url(); ?>" target="_blank">
                <span><i class="icon wb-globe" aria-hidden="true"></i> Open Website</span>
            </a>
          </li>
          
          <?php $GET_UNREAD = $this->db->query("SELECT * FROM cd_message WHERE contact_status = 'U' ORDER BY contact_logtime DESC"); ?>
          <li class="dropdown">
            <a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false" data-animation="slide-bottom" role="button">
              <i class="icon wb-envelope" aria-hidden="true"></i>
                <?php if($GET_UNREAD->num_rows() > 0) { ?>
                <span class="badge badge-info up"><?php echo $GET_UNREAD->num_rows(); ?></span>
                <?php } ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
              <li class="dropdown-menu-header" role="presentation">
                <h5>MESSAGES</h5>
                <?php if($GET_UNREAD->num_rows() > 0) { ?>
                <span class="label label-round label-info">New <?php echo $GET_UNREAD->num_rows(); ?></span>
                <?php } ?>
              </li>

              <li class="list-group" role="presentation">
                <div data-role="container">
                  <div data-role="content">
                    
                    <?php 
                      if($GET_UNREAD->num_rows() > 0) {
                      foreach($GET_UNREAD->result() as $rsMessage): ?>
                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online">
                            <img src="<?php echo base_url("assets/backend/portraits/default.png"); ?>" alt="..." />
                            <i></i>

                        </div>
                        <div class="media-body">
                          <h6 class="media-heading"><?php echo $rsMessage->contact_name; ?></h6>
                          <div class="media-meta">
                            <time datetime="<?php echo $rsMessage->contact_logtime; ?>">
                                <?php
                                    echo dateDiff(date('Y-m-d H:i:s'), $rsMessage->contact_logtime) . "\n";
                                ?>
                            </time>
                          </div>
                          <div class="media-detail"><?php echo word_limiter($rsMessage->contact_message, 25); ?></div>
                        </div>
                      </div>
                    </a>
                    <?php
                        endforeach;
                      } else {
                          echo "<p style='padding: 20px;'>No new inbox</p>";
                      }
                    ?>
                    
                  </div>
                    
                  <div class="col-md-12 col-sm-12" style="padding: 0px; ">
                        <button class="btn btn-default col-sm-12" type="button" style="border-radius: 0px;" onclick="javascript:location.href='<?php echo base_url('cms/inbox'); ?>'">View All</button>
                  </div>
                    
                </div>
              </li>
              
            </ul>
          </li>
            
          
          
          <li class="dropdown">
            <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="slide-bottom" role="button">
                <span class="avatar avatar-online">
                    <?php $GET_PROFILE = $this->db->get_where('cd_admin_users', array('admin_users_uid' => $this->session->userdata('sess_cpanelx_uid'))); ?>
                    <img src="<?php echo base_url("pubs/uploads/".$GET_PROFILE->row()->admin_users_avatar); ?>" alt="...">
                    <i></i>
                </span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li role="presentation">
                <a href="<?php echo base_url('cms/user/editdata/'.$this->session->userdata('sess_cpanelx_uid')); ?>" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
              </li>
              <li class="divider" role="presentation"></li>
              <li role="presentation">
                <a href="javascript:void(0)" role="menuitem" data-target="#POPUP_NOTIFY" data-toggle="modal"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
              </li>
            </ul>
          </li>
          
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->

    </div>
  </nav>
    
  <div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
            <ul class="site-menu">
                <li class="site-menu-category">General</li>
                
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Dashboard') { echo "active open"; } ?>">
                    <a href="#" data-slug="dashboard" onclick="javascript:location.href='<?php echo base_url('cms'); ?>'">
                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Dashboard</span>
                    </a>
                </li>
                <!--
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Media') { echo "active open"; } ?>">
                <a href="#" data-slug="dashboard" onclick="javascript:location.href='<?php echo base_url('cms/media'); ?>'">
                <i class="site-menu-icon wb-folder" aria-hidden="true"></i>
                <span class="site-menu-title">Media</span>
                </a>
                </li>
                -->
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'about') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-question-circle" aria-hidden="true"></i>
                        <span class="site-menu-title">About</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_ABOUT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/about'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All About</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_ABOUT_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/about/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'download') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-download" aria-hidden="true"></i>
                        <span class="site-menu-title">Article E-book</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_DOWNLOAD') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/download'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Article</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_DOWNLOAD_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/download/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New Article</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_DOWNLOAD_CAT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/download_cat'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Article Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'events') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-tags" aria-hidden="true"></i>
                        <span class="site-menu-title">Events</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_EVENTS') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/events'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Events</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_EVENTS_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/events/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New Event</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Gallery') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-file-picture-o" aria-hidden="true"></i>
                        <span class="site-menu-title">Gallery</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_GALLERY') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/gallery'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Gallery</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'members') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-user" aria-hidden="true"></i>
                        <span class="site-menu-title">Members</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MEMBERS') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/members'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Members</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MEMBERS_CAT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/members_cat'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Members Category</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MEMBERS_DUE') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/members_due'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Members Due</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'mitra') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-group" aria-hidden="true"></i>
                        <span class="site-menu-title">Mitra</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MITRA') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/mitra'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Mitra</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MITRA_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/mitra/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New</span>
                            </a>
                        </li>
                        <!-- 
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MITRA_CAT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/mitra_cat'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Mitra Category</span>
                            </a>
                        </li>
                        -->
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'news') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-edit" aria-hidden="true"></i>
                        <span class="site-menu-title">News</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_NEWS') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/news'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All News</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_NEWS_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/news/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New News</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_NEWS_CATEGORY') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/news_cat'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">News Category</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Pages') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-files-o" aria-hidden="true"></i>
                        <span class="site-menu-title">Pages</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_PAGES') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/pages'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Pages</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_PAGES_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/pages/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New Pages</span>
                            </a>
                        </li>
                    </ul>
                </li>

                
                
                
                
                
                
                
                
                
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'sdg') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-question-circle" aria-hidden="true"></i>
                        <span class="site-menu-title">Philantropy SDGs</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SDG') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/sdg'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All SDGs</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SDG_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/sdg/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Slider') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-sliders" aria-hidden="true"></i>
                        <span class="site-menu-title">Slider</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SLIDER') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/slider'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Slider</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SLIDER_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/slider/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New Slider</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Subscribe') { echo "active open"; } ?>">
                    <a href="#" data-slug="dashboard" onclick="javascript:location.href='<?php echo base_url('cms/subscribe'); ?>'">
                        <i class="site-menu-icon fa-envelope-o" aria-hidden="true"></i>
                        <span class="site-menu-title">Subscribe Email</span>
                    </a>
                </li>
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'sosmed') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon fa-share-alt" aria-hidden="true"></i>
                        <span class="site-menu-title">Social Media</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SOSMED') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/sosmed'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Social Media</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SOSMED_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/sosmed/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New Slider</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'Apperance') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon wb-settings" aria-hidden="true"></i>
                        <span class="site-menu-title">Apperance</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_MENUS' or $STR_PAGES == 'PAGE_MENUS_ADDNEW' or $STR_PAGES == 'PAGE_MENUS_EDIT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/menus'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Menus</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_SETTING') { echo "active"; } ?>">
                            <a class="animsition-link" data-slug="uikit-colors" href="<?php echo base_url('cms/setting'); ?>">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Company</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_GENERAL') { echo "active"; } ?>">
                            <a class="animsition-link" data-slug="uikit-colors" href="<?php echo base_url('cms/general'); ?>">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">General</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_LABEL' or $STR_PAGES == 'PAGE_LABEL_ADDNEW' or $STR_PAGES == 'PAGE_LABEL_EDIT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/label'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Label</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_EMAIL' or $STR_PAGES == 'PAGE_EMAIL_EDIT') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/email'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Email Layout</span>
                            </a>
                        </li>
                        <!--
                        <?php if(GET_COMPANY('multilanguage') == 'Y') { ?>
                            <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_LANGUAGE') { echo "active"; } ?>">
                                <a class="animsition-link" data-slug="uikit-colors" href="<?php echo base_url('cms/lang'); ?>">
                                    <i class="site-menu-icon " aria-hidden="true"></i>
                                    <span class="site-menu-title">Language</span>
                                </a>
                            </li>
                        <?php } ?>
                        -->
                    </ul>
                </li>
                
                <!--
                <li class="site-menu-item has-sub <?php if($STR_MENU == 'User') { echo "active open"; } ?>">
                    <a href="javascript:void(0)" data-slug="uikit">
                        <i class="site-menu-icon wb-user" aria-hidden="true"></i>
                        <span class="site-menu-title">Users</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_USER') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/user'); ?>" data-slug="uikit-buttons">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">All Users</span>
                            </a>
                        </li>
                        <li class="site-menu-item <?php if($STR_PAGES == 'PAGE_USER_ADDNEW') { echo "active"; } ?>">
                            <a class="animsition-link" href="<?php echo base_url('cms/user/addnew'); ?>" data-slug="uikit-colors">
                                <i class="site-menu-icon " aria-hidden="true"></i>
                                <span class="site-menu-title">Add New</span>
                            </a>
                        </li>
                    </ul>
                </li>
                -->
            </ul>
        </div>
      </div>
    </div>

    
  </div>

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

  <script src="<?php echo base_url("assets/backend/vendor/bootstrap-table/bootstrap-table.min.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/matchheight/jquery.matchHeight-min.js"); ?>"></script>

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
  <script src="<?php echo base_url("assets/backend/js/components/slidepanel.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/switchery.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/gmaps.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/js/components/matchheight.js"); ?>"></script>

  <script src="<?php echo base_url("assets/backend/vendor/bootbox/bootbox.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/bootstrap-sweetalert/sweet-alert.js"); ?>"></script>
  <script src="<?php echo base_url("assets/backend/vendor/toastr/toastr.js"); ?>"></script>
    
  <!-- Page -->
    <?php 
        if (isset($content) AND $content != NULL) {
            include $content;
        } else {
            include "page_404.php";
        }

    ?>
  <!-- End Page -->

  <!-- Modal -->
  <div class="modal fade modal-fade-in-scale-up" id="POPUP_NOTIFY" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">LOGOUT</h4>
            </div>
            <div class="modal-body">
                <p>Are your sure logout ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default margin-0" data-dismiss="modal">NO</button>
                <button type="button" class="btn btn-primary" onclick="javascript:location.href='<?php echo base_url('cms/cpanelx/logout'); ?>'">Yes</button>
            </div>
        </div>
    </div>
  </div>
  <!-- End Modal -->

  <!-- Footer -->
  <footer class="site-footer">
    <span class="site-footer-legal">© 2016 Codeq-Solutions System</span>
  </footer>
    
  

  <script type="text/javascript">
    $(document).ready(function($) {

      Site.run();
        
    });
  </script>
</body>

</html>