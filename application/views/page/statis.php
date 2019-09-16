<?php
    if ($pages->posts_images != '' && file_exists('./pubs/uploads/'.$pages->posts_images) == true) {
        $background_image   = 'style="background-image: url('.base_url('pubs/uploads/'.$pages->posts_images).');"';
    } else {
        $background_image   = '';
    }

    if ($pages->posts_type == 'sdg') {
        $cate_pages                 = 'Philanthropy for SDG';
        $title_pages                = $cate_pages;
        $subtitle_pages             = $pages->posts_title;
    } else if ($pages->posts_type == 'pages') {
        $title_pages                = $pages->posts_title;
        $subtitle_pages             = $pages->posts_subtitle;
    }

?>

<div class="page">
    <div class="page-banner" <?php echo $background_image; ?>>
        <div class="title-banner">
            <label><?php echo $title_pages; ?></label>
        </div>
    </div>
    <div class="page-container">
        <div class="breadcrumbs">
            <a href="<?php echo base_url(); ?>" id="home-breadcrumbs">Home</a>
            <i class="fa fa-angle-right"></i>
            <span><?php echo $title_pages; ?></span>
        </div>
        <div class="page-frame">
            <label class="title"><?php echo $subtitle_pages; ?></label>
            <?php
                echo $pages->posts_content; 
            ?>
        </div>
    </div>
</div>
