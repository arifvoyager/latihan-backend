<!-- Resposiveslides CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/responsiveslides/responsiveslides.css'); ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url('assets/responsiveslides/themes/themes.css'); ?>" type="text/css" />

<!-- Validation Javascript file -->
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/formValidation.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/framework/bootstrap.js'); ?>" type="text/javascript"></script>

<!-- FlexSlider -->
<script defer src="<?php echo base_url('assets/flexslider/jquery.flexslider2.js'); ?>"></script>

<!-- Demo CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/flexslider/flexslider2.css'); ?>" type="text/css" media="screen" />

<?php
	$CURRENT_LANG	= GET_CURRENT_LANG();

?>

<div class="slider-frame">
    <div class="rslides_container">
        <ul class="rslides" id="slider1">
            <?php
                $get_slider     = $this->db->get_where('cd_posts', array('posts_type' => 'slider', 'posts_status' => 'Y', 'posts_lang' => $LANG['code']));
                        
                foreach($get_slider->result() as $slider):
                    echo '<li>';
                    echo '  <img src="'.base_url('pubs/uploads/'.$slider->posts_images).'" alt="">';

                    if ($slider->posts_title != "" && $slider->posts_shortdesc != "") {
                        //echo '  <div class="caption" onclick="javascript:location.href=\''.$slider->posts_link.'\'">';
                        
                        echo '  <div class="caption">';
                        echo '      <label>'.$slider->posts_title.'</label>';
                        echo '      <p>'.$slider->posts_shortdesc.'</p>';

                        if ($slider->posts_link != '') {
                            $l_category   = array(
                                'news'      => array('id' => 'berita', 'en' => 'news'),
                                'events'    => array('id' => 'acara', 'en' => 'events'),
                                'about'     => array('id' => 'tentang-kami', 'en' => 'about-us'),
                                'gallery'   => array('id' => 'gallery', 'en' => 'galeri'),
                                'standards' => array('id' => 'standar-pedoman', 'en' => 'standards-guidelines')
                            );
                            
                            $slider_link    = str_replace(base_url(), '', $slider->posts_link);
                            if(strpos($slider->posts_link, base_url()) !== false) {
                                $slug_link      = explode('/', $slider_link);

                                if ($slug_link[0] == 'berita' || $slug_link[0] == 'news') {
                                    $c_slug         = $l_category['news'];
                                    $posts_type     = 'news';
                                    $c_slug_type    = 'news_cat';
                                } else if($slug_link[0] == 'acara' || $slug_link[0] == 'events') {
                                    $c_slug         = $l_category['events'];
                                    $posts_type     = 'events';
                                } else if($slug_link[0] == 'tentang-kami' || $slug_link[0] == 'about-us') {
                                    $c_slug         = $l_category['about'];
                                } else if($slug_link[0] == 'gallery' || $slug_link[0] == 'galeri') {
                                    $c_slug         = $l_category['gallery'];
                                } else if($slug_link[0] == 'standar-pedoman' || $slug_link[0] == 'standards-guidelines') {
                                    $c_slug         = $l_category['standards'];
                                    $c_slug_type    = 'download_cat';
                                } else {
                                    $c_slug         = $l_category['news'];
                                    $posts_type     = 'news';
                                }

                                if(isset($slug_link[2]) == true) {
                                    $slug_link_caption = $slug_link[2];
                                    $get_link  = $this->db->get_where('cd_posts', array('posts_type' => $posts_type, 'posts_slug' => $slug_link_caption));
                                    $get_other_link = $this->db->get_where('cd_posts', array('posts_type' => $posts_type, 'posts_lock_code' => $get_link->row()->posts_lock_code, 'posts_lang ' => $LANG['code']));
                                    
                                    $s_link         = base_url().$c_slug[$LANG['code']].'/d/'.$get_other_link->row()->posts_slug;
                                } elseif(isset($slug_link[2]) == false) {
                                    $c_slug_category    = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => $c_slug_type, 'taxonomy_slug' => $slug_link[1]))->row()->taxonomy_lock_code;
                                    $c_slug_category    = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => $c_slug_type, 'taxonomy_lock_code' => $c_slug_category, 'taxonomy_lang' => $LANG['code']))->row();

                                    $s_link         = base_url().$c_slug[$LANG['code']].'/'.$c_slug_category->taxonomy_slug;
                                } elseif(isset($slug_link[2]) == false && isset($slug_link[1]) == false) {
                                    $s_link         = base_url().$c_slug[$LANG['code']];
                                }
                            } else {
                                $s_link         = $slider->posts_link;
                            }
                            echo '      <a class="button btn-srad" href="'.$s_link.'">'.GET_LABEL('LINK_EXPLORE_MORE', $LANG['code']).'</a>';
                        }

                        echo '</div>';
                    }
                    echo '</li>';
                endforeach;
            ?>
        </ul>
    </div>
    <div class="fl-clear"></div>
</div>

<div class="default-sdg">
    <div class="sdg-list">
        <label class="title fontsize24"><?php echo GET_LABEL('TITLE_PHILANTROPY_SDG', $LANG['code']); ?></label>
        <?php
            $get_sdg    = $this->db->get_where('cd_posts', array('posts_type' => 'sdg', 'posts_lang' => $LANG['code'], 'posts_status' => 'Y'));
            
            foreach ($get_sdg->result() as $sdg) :
                ?>
                    <div class="sdg-item col-xs-12 col-sm-4 col-md-4 col-lg-4" onclick="javscript:location.href='<?php echo base_url($sdg->posts_slug); ?>'">
                        <div class="sdg-item-image">
                            <img src="<?php echo base_url('pubs/uploads/images/'.$sdg->posts_images); ?>" />
                        </div>
                        <div class="sdg-item-desc">
                            <label><?php echo $sdg->posts_title; ?></label>
                            <p><?php echo $sdg->posts_shortdesc; ?></p>
                        </div>
                    </div>
                <?php
            endforeach;
        ?>
        <div class="fl-clear"></div>
    </div>
</div>

<div class="default-about">
    <div class="da-image">
        <img src="<?php echo base_url('pubs/uploads/about-1.jpg'); ?>" />
    </div>
    <div class="da-info">
        <div>
            <?php
                $array_about    = array(
                    'id'    => 'tentang-kami',
                    'en'    => 'about-us'
                );
            ?>
            <label class="title"><?php echo GET_GENERAL('welcome_homepage_title', $LANG['code']); ?></label>
            <p><?php echo GET_GENERAL('welcome_homepage_text', $LANG['code']); ?></p>
            <label class="button btn-srad btn-bggrey btn-p10" onclick="javascript:location.href='<?php echo base_url($array_about[$LANG['code']]); ?>'"><?php echo GET_LABEL('BUTTON_SEE_MORE', $LANG['code']); ?></label>
        </div>
    </div>
    <div class="fl-clear"></div>
</div>

<div class="default-form">
    <div class="df-join col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
        <div class="df-frame fl-right">
            <?php
                $array_member    = array(
                    'id'    => 'keanggotaan',
                    'en'    => 'membership'
                );
            ?>
            
            <img class="df-frame-image" src="<?php echo base_url('pubs/uploads/image-join.png'); ?>" />
            <label class="fontsize36"><?php echo GET_LABEL('TITLE_JOIN_MEMBERSHIP', $LANG['code']); ?></label>
            <p><?php echo GET_GENERAL('join_our_membership_text', $LANG['code']); ?></p>
            <label class="button btn-srad btn-p10 btn-bgred" onclick="javascript:location.href='<?php echo $array_member[$LANG['code']]; ?>'"><?php echo GET_LABEL('BUTTON_SEE_MORE', $LANG['code']); ?></label>
        </div>
    </div>
    <div class="df-subs col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
        <div class="df-frame fl-left">
            <img class="df-frame-image" src="<?php echo base_url('pubs/uploads/image-subs.png'); ?>" />
            <label class="fontsize36"><?php echo GET_LABEL('TITLE_SUBSCRIBE_EMAIL', $LANG['code']); ?></label>
            <p><?php echo GET_GENERAL('subscribe_email_text', $LANG['code']); ?></p>
            <div class="subscribe-form">
                <form method="post" name="formSubscribe" id="formSubscribe">
                    <input type="text" name="subscribe_email" id="subscribe_email" placeholder="<?php echo GET_LABEL('PLACEHOLDER_EMAIL_SUBSCRIBE', $LANG['code']); ?>" />
                    <i class="fa fa-send" id="subscribeEmailButton"></i>
                </form>
            </div>
        </div>
    </div>
    <div class="fl-clear"></div>
</div>

<div class="default-info">
    <div class="dif-left col-xs-12 col-sm-6 col-md-6 col-ld-6">
        <?php 
            $get_news               = $this->db->get_where('cd_posts', array('posts_type' => 'news', 'posts_lang' => $LANG['code']), 'posts_date', 'DESC', 4, 0);

            $array_news    = array(
                'id'    => 'berita',
                'en'    => 'news'
            );
        ?>
        <label class="fontsize24"><?php echo GET_LABEL('TITLE_RECENT_NEWS', $LANG['code']); ?></label>
        <div class="di-frame">
            <?php
                foreach ($get_news->result() as $key=>$news):
                    echo '<div class="di-frame-list">';

                    if ($key == 0 && $news->posts_images != '') {
                        echo '    <img class="fl-left" src="'.base_url('pubs/uploads/'.$news->posts_images).'" />';
                    }

                    echo '    <label onclick="javascript:location.href=\''.base_url($array_news[$LANG['code']].'/d/'.$news->posts_slug).'\'">'.$news->posts_title.'</label>';
                    echo '    <span>'.date("d F Y", strtotime($news->posts_date)).'</span>';
                    echo '    <div class="fl-clear"></div>';
                    echo '</div>';
                endforeach;
            ?>
            <a href="javascript:location.href='<?php echo base_url($array_news[$LANG['code']]); ?>';"><?php echo GET_LABEL('LINK_SEE_ALL_NEWS', $LANG['code']); ?></a>
        </div>
    </div>
    <div class="dif-right col-xs-12 col-sm-6 col-md-6 col-ld-6">
        <?php
            $today          = date('Y-m-d');
    
            $get_events_up  = $this->db->query('SELECT * FROM cd_posts WHERE posts_type = "events" AND posts_lang = "'.$LANG['code'].'" AND (posts_start_date >= "'.$today.'" OR posts_end_date >= "'.$today.'") ORDER BY posts_start_date ASC LIMIT 0, 3');
            $events         = $this->db->query('SELECT * FROM cd_posts WHERE posts_type = "events" AND posts_lang = "'.$LANG['code'].'" AND (posts_start_date >= "'.$today.'" OR posts_end_date >= "'.$today.'") ORDER BY posts_start_date ASC LIMIT 0, 3');
            
            $array_events    = array(
                'id'    => 'acara',
                'en'    => 'events'
            );
        ?>
        <label class="fontsize24"><?php echo GET_LABEL('TITLE_RECENT_EVENT', $LANG['code']); ?></label>
        <div class="di-frame">
            <?php
                if ($events->num_rows() > 0) {
                    ?>
                    <div class="di-frame-image">
                        <img src="<?php echo base_url('pubs/uploads/'.$events->row()->posts_images); ?>" />
                    </div>
                    <div class="di-frame-list">
                        <label class="title" onclick="javascript:location.href='<?php echo base_url($array_events[$LANG['code']].'/d/'.$events->row()->posts_slug); ?>';"><?php echo $events->row()->posts_title; ?></label>
                        <span><?php echo date("d F Y", strtotime($events->row()->posts_date)); ?></span>
                        <p><?php echo $events->row()->posts_shortdesc; ?></p>
                    </div>
                    <a href="javascript:location.href='<?php echo base_url($array_events[$LANG['code']]); ?>';"><?php echo GET_LABEL('LINK_SEE_ALL_EVENTS', $LANG['code']); ?></a>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="fl-clear"></div>
</div>

<div class="default-download">
    <div class="dd-list">
        <?php
            $get_download       = $this->db->get_where('cd_posts', array('posts_type' => 'download', 'posts_lang' => $LANG['code'], 'posts_locked' => 'Y'), 'posts_date', 'DESC', 3, 0);

            foreach ($get_download->result() as $download) :
                ?>
                    <div class="dd-item col-xs-12 col-sm-4 col-md-4 col-lg-4 no-padding">
                        <div class="dd-item-img">
                            <img src="<?php echo base_url('pubs/uploads/images/'.$download->posts_images); ?>" />
                        </div>
                        <label><?php echo $download->posts_title; ?></label>
                        
                        <?php
                            if ($download->posts_visibility == 'M') {
                                echo '<span id="member_article">'.GET_LABEL('LINK_CLICK_TO_DOWNLOAD', $LANG['code']).'</span>';
                            } else {
                                echo '<a href="'.base_url('pubs/file/'.$download->posts_file).'" target="_blank">'.GET_LABEL('LINK_CLICK_TO_DOWNLOAD', $LANG['code']).'</a>';
                            }
                        ?>
                        
                    </div>
                <?php
            endforeach;
        ?>
        <div class="fl-clear"></div>
    </div>
</div>

<div class="default-client">
    <label class="fontsize26 text-center fontcolorred"><?php echo GET_LABEL('TITLE_OUR_PARTNER', $LANG['code']); ?></label>
    <div class="flexslider col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
        <ul class="slides">
            <?php
                $get_mitra      = $this->db->get_where('cd_posts', array('posts_type' => 'mitra', 'posts_lang' => $LANG['code']));

                foreach ($get_mitra->result() as $mitra) :
                    echo '<li>';
                    echo '    <img src="'.base_url('pubs/uploads/'.$mitra->posts_images).'" />';
                    echo '</li>';
                endforeach;
            ?>
        </ul>
    </div>
    <div class="fl-clear"></div>
</div>

<div class="default-client">
    <label class="fontsize26 text-center fontcolorgreen"><?php echo GET_LABEL('TITLE_OUR_MEMBERS', $LANG['code']); ?></label>
    <div class="flexslider col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
        <ul class="slides">
            <?php
                $get_member      = $this->db->get_where('cd_member', array('member_status' => 'Active'));

                foreach ($get_member->result() as $member) :
                    if ($member->member_logo != '') {
                        $member_logo        = 'pubs/uploads/'.$member->member_logo;
                    } else {
                        $member_logo        = 'pubs/uploads/images/NoLogo.jpg';
                    }

                    echo '<li>';
                    echo '    <img src="'.base_url($member_logo).'" />';
                    echo '</li>';
                endforeach;
            ?>
        </ul>
    </div>
    <div class="fl-clear"></div>
</div>
<div class="sosmed-page default-client"> 
    <label class="fontsize26 text-center fontcolorgreen btn-p14"><?php echo GET_LABEL('TITLE_OUR_SOCIALMEDIA', $LANG['code']); ?></label>
    <div class="sosmed-page-twitter col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <a class="twitter-timeline" data-height="495" data-dnt="true" data-theme="light" href="https://twitter.com/FilantropiINA">Tweets by FilantropiINA</a> 
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    <div class="sosmed-page-fanspage col-xs-12 col-sm-6 col-md-6 col-lg-6 no-right-padding">
        <div class="fb-page" data-href="https://www.facebook.com/FilantropiIndonesia/" data-tabs="timeline,events,messages" data-small-header="true" data-adapt-container-width="true" data-width="465" data-hide-cover="false" data-show-facepile="false">
            <blockquote cite="https://www.facebook.com/FilantropiIndonesia/" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/FilantropiIndonesia/">Filantropi Indonesia</a>
            </blockquote>
        </div>     
    </div>
    <div class="fl-clear"></div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/responsiveslides/responsiveslides.js'); ?>"></script>
<script src="<?php echo base_url('assets/sweetalert/sweet-alert.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/sweetalert/sweet-alert.css'); ?>" rel="stylesheet">

<script>
    jQuery(document).ready(function($) {
        /**
         * identifier variable must be unique ID
         */
        $("#slider1").responsiveSlides({
            speed: 2000,
            pager: true,
            namespace: "centered-btns"
        });
    });		
         
    $('#subscribeEmailButton').click(function() {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('mainpage/subscribe'); ?>',
            data: $('#formSubscribe').serialize(),
            success: function(data){
                console.log(data);
                if (data == 'email_already_exist') {
                    swal({
                            title: "<?php echo GET_LABEL('TITLE_FAILED_SUBSCRIBE', $CURRENT_LANG['code']); ?>",
                            text: "<?php echo GET_LABEL('TEXT_FAILED_SUBSCRIBE', $CURRENT_LANG['code']); ?>",
                            type: "error"
                        });
                } if (data == 'success') {
                    swal({
                            title: "<?php echo GET_LABEL('TITLE_SUCCESS_SUBSCRIBE', $CURRENT_LANG['code']); ?>",
                            text: "<?php echo GET_LABEL('TEXT_SUCCESS_SUBSCRIBE', $CURRENT_LANG['code']); ?>",
                            type: "success"
                        },
                        function () {
                            window.location.href = BASE_URL;
                        });
                }                
            }
        });
    });
                
                
                
    $('#member_article').click(function() {
        swal({
            title: "<?php echo GET_LABEL('TITLE_FAILED_DOWNLOAD', $CURRENT_LANG['code']); ?>",
            text: "<?php echo GET_LABEL('TEXT_FAILED_DOWNLOAD', $CURRENT_LANG['code']); ?>",
            type: "success"
        },
        function () {
            window.location.href = BASE_URL+"member/login";
        });
    });
    
    $(window).load(function() {
        $('.flexslider').flexslider2({
            animation: "slide",
            animationLoop: true,
            itemWidth: 152,
            itemMargin: 10,
            nextText : '',
            prevText : '',
            directionNav : false,
            controlNav: false
        });
    });  
    
</script>