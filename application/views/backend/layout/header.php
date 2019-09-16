<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided" data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search" data-toggle="collapse">
            <span class="sr-only">Toggle Search</span>
            <i class="icon wb-search" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle">
            <?php
                $FILENAME = './pubs/uploads/'.GET_COMPANY('company_logo');
                if(file_exists($FILENAME)) {
                    echo '<img class="navbar-brand-logo" src="'.$FILENAME.'" title="Filantropi Indonesia Admin Panel">';
                } else {
                    echo '<img class="navbar-brand-logo" src="'.base_url("assets/backend/example-images/logo-jawata.png").'" title="Jawata Admin">';
                }
            ?>

            <span class="navbar-brand-text"> Admin Panel</span>
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

                <?php 
                    $GET_UNREAD = $this->db->query("SELECT * FROM dp_message WHERE contact_status = 'U' ORDER BY contact_logtime DESC"); 
                    ?>
                
                    <li class="dropdown">
                        <a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false" data-animation="slide-bottom" role="button">
                            <i class="icon wb-envelope" aria-hidden="true"></i>
                            <?php 
                                if($GET_UNREAD->num_rows() > 0) {
                                    echo '<span class="badge badge-info up">'.$GET_UNREAD->num_rows().'</span>';
                                } 
                            ?>
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
                                                                </span>
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
                                        <button class="btn btn-default col-sm-12" type="button" style="border-radius: 0px;" onclick="javascript:location.href='<?php echo base_url('jpanel/inbox'); ?>'">View All</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>



                <li class="dropdown">
                    <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="slide-bottom" role="button">
                        <span class="avatar avatar-online">
                            <!--
                            <?php $GET_PROFILE = $this->db->get_where('dp_userlogin', array('userlogin_uid' => $this->session->userdata('sess_cpanelx_uid'))); ?>
                            <img src="<?php echo base_url("pubs/uploads/".$GET_PROFILE->row()->userlogin_avatar); ?>" alt="...">
                            <i></i>
                            -->
                        </span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation">
                            <a href="<?php echo base_url('jpanel/user/editdata/'.$this->session->userdata('sess_cpanelx_uid')); ?>" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
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
