<?php
    $news_category          = $this->db->get_where('cd_taxonomy', array('taxonomy_lang' => $LANG['code'], 'taxonomy_slug' => $this->uri->segment(2)))->row()->taxonomy_lock_code;   

    $get_news               = $this->db->get_where('cd_posts', array('posts_type' => 'news', 'posts_lang' => $LANG['code'], 'posts_category' => $news_category), 'posts_date', 'DESC');
    
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
            <div class="page-news">
                <div class="news-list col-xs-12 col-sm-9 col-md-9 col-lg-9">
                    <?php 
                    if ($get_news->num_rows() > 0) {
                        foreach ($get_news->result() as $news): 
                            ?>
                                <div class="news-item">
                                    <label class="title-news"><?php echo $news->posts_title; ?></label>
                                    
                                    <?php
                                        if ($news->posts_images != '') {
                                            echo '<img src="'.base_url('pubs/uploads/'.$news->posts_images).'" />';
                                        }
                                    ?>
                                    <div class="news-item-info">
                                        <span>Posted : <?php echo date("d F Y", strtotime($news->posts_date)); ?></span>
                                        <p><?php echo $news->posts_shortdesc; ?></p>
                                        <label class="button btn-srad btn-bgorange btn-p12" onclick="javascript:location.href='<?php echo base_url($this->uri->segment(1).'/d/'.$news->posts_slug); ?>'">
                                            <?php echo GET_LABEL('BUTTON_READ_MORE', $LANG['code']); ?>
                                        </label>
                                    </div>
                                    <div class="fl-clear"></div>
                                </div>
                            <?php 
                        endforeach;
                    } else {
                        echo '<div class="news-item">';
                        echo GET_LABEL('LABEL_NO_NEWS', $LANG['code']);
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="sidebar-page col-xs-12 col-sm-3 col-md-3 col-lg-3">
                    <?php echo $this->load->view('layout/sidebar.php', array('sidebar' => 'popular-news')); ?>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>