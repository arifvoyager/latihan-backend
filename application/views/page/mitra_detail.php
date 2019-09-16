<?php
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
            <span><?php echo $pages->posts_subtitle; ?></span>
        </div>
        <div class="page-frame page-mitra">
            <div class="mitra-detail">
                <div class="mitra-detial-image col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <img class="img-responsive" src="<?php echo base_url('pubs/uploads/'.$mitra->posts_images); ?>" />
                </div>
                <div class="mitra-detial-profile col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <label class="title"><?php echo $mitra->posts_title; ?></label>
                    <?php echo $mitra->posts_content; ?>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>