<?php
    $uri_slug               = $this->uri->segment(3);
    $organisasi             = $this->db->get_where('cd_member', array('member_slug' => $uri_slug))->row();

    if ($pages->posts_images != '') {
        $background_image   = 'style="background-image: url('.base_url('pubs/uploads/'.$pages->posts_images).');"';
    } else {
        $background_image   = '';
    }

    if ($LANG['code'] == 'id') {
        $profile    = $organisasi->member_profile_id;
    } else {
        $profile    = $organisasi->member_profile_en;
    }

    if ($organisasi->member_logo != '') {
        $organisasi_logo        = 'pubs/uploads/'.$organisasi->member_logo;
    } else {
        $organisasi_logo        = 'pubs/uploads/images/NoLogo.jpg';
    }

?>
<div class="page">
    <div class="page-banner" <?php echo $background_image; ?>>
        <div class="title-banner">
            <label><?php echo $pages->posts_title; ?></label>
        </div>
    </div>
    <div class="page-container">
        <div class="breadcrumbs">
            <a href="<?php echo base_url(); ?>" id="home-breadcrumbs">Home</a>
            <i class="fa fa-angle-right"></i>
            <a href="<?php echo base_url($pages->posts_slug); ?>" id="home-breadcrumbs"><?php echo $pages->posts_title; ?></a>
            <i class="fa fa-angle-right"></i>
            <span><?php echo $organisasi->member_name; ?></span>
        </div>
        <div class="page-frame page-mitra">
            <div class="mitra-detail">
                <div class="mitra-detial-image col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <img class="img-responsive" src="<?php echo base_url($organisasi_logo); ?>" />
                </div>
                <div class="mitra-detial-profile col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <label class="title"><?php echo $organisasi->member_name; ?></label>
                    <?php echo $profile; ?>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>