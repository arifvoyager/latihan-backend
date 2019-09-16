<?php
    $uri                    = $this->uri->segment(3);
    $get_about_detail       = $this->db->get_where('cd_posts', array('posts_type' => 'about', 'posts_slug' => $uri));
    $about                  = $get_about_detail->row();

    if ($pages->posts_images != '') {
        $background_image   = 'style="background-image: url('.base_url('pubs/uploads/'.$pages->posts_images).');"';
    } else {
        $background_image   = '';
    }

    $parent_pages           = $this->db->get_where('cd_posts', array('posts_lock_code' => $about->posts_parent, 'posts_lang' => $LANG['code']))->row();
?>

<div class="page">
    <div class="page-banner" <?php echo $background_image; ?>>
        <div class="title-banner">
            <label><?php echo $about->posts_title; ?></label>
        </div>
    </div>
    <div class="page-container">
        <div class="breadcrumbs">
            <a href="<?php echo base_url(); ?>" id="home-breadcrumbs">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?php echo base_url($parent_pages->posts_slug); ?>"><?php echo $parent_pages->posts_title; ?></a>
            <i class="fa fa-angle-right"></i>
            <span><?php echo $about->posts_title; ?></span>
        </div>
        <div class="page-frame col-xs-12 col-sm-9 col-md-9 col-lg-9 no-left-padding">
            <label class="title"><?php echo $about->posts_title; ?></label>
            <div class="page-about">
                <?php echo $about->posts_content; ?>
            </div>
        </div>
        <div class="sidebar-page col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'download-list')); ?>

            <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'member-list')); ?>
            
            <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'contact-us')); ?>
            <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'popular-news')); ?>
            <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'upcoming-events')); ?>
        </div>
        <div class="fl-clear"></div>
    </div>
</div>