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
        <div class="page-frame">
            <div class="page-mitra">
                <?php
                    echo '<div class="mitra-list col-xs-12 col-sm-12 col-md-12 col-lg-12">';

                    $get_mitra              = $this->db->get_where('cd_posts', array('posts_type' => 'mitra', 'posts_lang' => $LANG['code']));

                    foreach ($get_mitra->result() as $mitra) :

                        echo '<div class="mitra-item col-xs-6 col-sm-3 col-md-3 col-lg-3">';
                        echo '  <a href="'.$mitra->posts_link.'" target="_blank">';
                        echo '  <div class="mi-item">';
                        echo '      <div class="mitra-item-image">';
                        echo '          <img class="img-responsive" src="'.base_url('pubs/uploads/'.$mitra->posts_images).'" />';
                        echo '      </div>';
                        echo '      <span>'.$mitra->posts_title.'</span>';
                        echo '  </div>';
                        echo '  </a>';
                        echo '</div>';
                    endforeach;
                    echo '  <div class="fl-clear"></div>';
                    echo '</div>';
                ?>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>