<?php
    $CURRENT_LANG	    = GET_CURRENT_LANG();
    $get_about              = $this->db->get_where('cd_posts', array('posts_type' => 'about', 'posts_status' => 'Y', 'posts_lang' => $CURRENT_LANG['code']));
    
    if ($pages->posts_images != '') {
        $background_image   = 'style="background-image: url('.base_url('pubs/uploads/'.$pages->posts_images).');"';
    } else {
        $background_image   = '';
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
            <span><?php echo $pages->posts_title; ?></span>
        </div>
        <div class="page-frame">
            <label class="title"><?php echo $pages->posts_subtitle; ?></label>
            <p><?php echo $pages->posts_shortdesc; ?></p>

            <div class="page-about-list">
                <?php
                    foreach ($get_about->result() as $about):
                        ?>
                            <div class="about-item col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                <label class="title-about"><?php echo $about->posts_title; ?></label> 
                                <div class="about-image">
                                    <img class="ai-image" src="<?php echo base_url('pubs/uploads/'.$about->posts_images); ?>" />
                                </div>
                                <p><?php echo makeChunk($about->posts_shortdesc, 145); ?></p>
                                <label class="button btn-bggrey btn-srad btn-p12" onclick="javascript:location.href='<?php echo base_url($this->uri->segment(1).'/d/'.$about->posts_slug); ?>'"><?php echo GET_LABEL('BUTTON_SEE_DETAIL', $LANG['code']); ?></label>
                            </div>
                        <?php
                    endforeach;
                ?>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>
