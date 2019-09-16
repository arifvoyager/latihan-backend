<?php
    $news                   = $this->db->get_where('cd_posts', array('posts_type' => 'news', 'posts_lang' => $LANG['code'], 'posts_slug' => $this->uri->segment(3)))->row();

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
            <a href="<?php echo base_url($pages->posts_slug); ?>" id="home-breadcrumbs"><?php echo $pages->posts_subtitle; ?></a>
            <i class="fa fa-angle-right"></i>
            <span><?php echo $news->posts_title; ?></span>
        </div>
        <div class="page-frame">
            <div class="page-news">
                <div class="news-list col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <div class="news-detail">
                        <label class="title-news"><?php echo $news->posts_title; ?></label>
                        
                        <?php 
                            if ($news->posts_images != '') {
                                echo '<img src="'.base_url('pubs/uploads/'.$news->posts_images).'" />';
                            }
                        ?>
                        <div class="news-item-info">
                            <span><?php echo GET_LABEL('LABEL_POSTED', $LANG['code']).' : '.date("d F Y", strtotime($news->posts_date)); ?></span>
                            <?php echo $news->posts_content; ?>
                        </div>
                        <?php
                            if ($news->posts_source != '') {
                                ?>
                                    <span class="source"><?php echo GET_LABEL('LABEL_SOURCE', $LANG['code']).' : '.$news->posts_source; ?></span>
                                <?php 
                            }
                        ?>
                        <div class="fl-clear"></div>
                    </div>
                </div>
                <div class="sidebar-page col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'popular-news')); ?>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>