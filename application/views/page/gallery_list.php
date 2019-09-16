<script src="<?php echo base_url("assets/backend/js/core.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/magnific-popup/magnific-popup.css"); ?>">

<script src="<?php echo base_url("assets/backend/vendor/magnific-popup/jquery.magnific-popup.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/js/components/magnific-popup.js"); ?>"></script>

<?php
    $uri_pages              = $this->uri->segment(1);
    $gallery_cate           = $this->db->query('SELECT * FROM cd_taxonomy WHERE taxonomy_flags = "GALLERY_CATEGORY" AND taxonomy_lang = "'.$LANG['code'].'" GROUP BY taxonomy_value');
    
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
            <?php
                if ($this->uri->segment(3) != false) {
                    $gallery_category       = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'GALLERY_CATEGORY', 'taxonomy_slug' => $this->uri->segment(3)))->row();

                    echo '<a href="'.base_url($this->uri->segment(1)).'" >'.$pages->posts_subtitle.'</a>';
                    echo '<i class="fa fa-angle-right"></i>';
                    echo '<span>'.$gallery_category->taxonomy_name.'</span>';
                } else {
                    echo '<span>'.$pages->posts_subtitle.'</span>';
                }
            ?>
        </div>
        <div class="page-frame">
            <div class="page-gallery">
                <div class="gallery-cate col-xs-12 col-sm-3 col-md-3 col-lg-3" id="accordion2">
                    <div class="" id="accordion">
                        <ul class="panel">
                            <li class="title">CATEGORY</li>
                            <?php
                                foreach ($gallery_cate->result() as $key=>$gallery_cat):
                                    $get_gallery_subcate    = $this->db->query('SELECT * FROM cd_taxonomy WHERE taxonomy_flags = "GALLERY_CATEGORY" AND taxonomy_value = "'.$gallery_cat->taxonomy_value.'" AND taxonomy_lang = "'.$LANG['code'].'"');
                                
                                    if ($gallery_cat->taxonomy_value == $this->uri->segment(2)) {
                                        $in     = 'in';
                                    } else {
                                        $in     = '';
                                    }
    
                                    echo '<li>';
                                    echo '    <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$key.'">';
                                    echo          $gallery_cat->taxonomy_value;
                                    echo '    </a>';
                                    echo '</li>';
                                    echo '<div id="collapse'.$key.'" class="panel-collapse collapse '.$in.'">';
                                    echo '    <ul class="gallery-subcate">';

                                    foreach ($get_gallery_subcate->result() as $gallery_subcate):
                                        if ($gallery_subcate->taxonomy_slug == $this->uri->segment(3)) {
                                            $active_subcate     = 'class="subcate-active"';
                                        } else {
                                            $active_subcate     = '';
                                        }

                                        echo '<li><a '.$active_subcate.' href="'.base_url($uri_pages.'/'.$gallery_cat->taxonomy_value.'/'.$gallery_subcate->taxonomy_slug).'">'.$gallery_subcate->taxonomy_name.'</a></li>';
                                    endforeach;

                                    echo '    </ul>';
                                    echo '</div>';
                                endforeach;
                            ?>
                        </ul>
                    </div>                    
                </div>
                <div class="gallery-list col-xs-12 col-sm-9 col-md-9 col-lg-9 no-padding">
                    <ul id="exampleZoomGallery">
                        <?php
                            $category_lock_code     = $this->db->get_where('cd_taxonomy', array('taxonomy_slug' => $this->uri->segment(3)))->row();
    
                            if ($this->uri->segment(3) == false) {
                                $get_gallery    = $this->db->query('SELECT * FROM cd_posts WHERE posts_type = "video" OR posts_type = "photo"');
                            } else {
                                $get_gallery    = $this->db->get_where('cd_posts', array('posts_parent' => $category_lock_code->taxonomy_lock_code));
                            }

                            foreach ($get_gallery->result() as $gallery):
                                if ($gallery->posts_category == 'video-link') {
                                    $get_video_id   = str_replace('https://www.youtube.com/watch?v=', '', $gallery->posts_link);
                                    ?>
                                        <li class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                            <div class="gallery-item">
                                                <div class="gal-item">
                                                    <a class="mfp-iframe" href="<?php echo $gallery->posts_link; ?>">
                                                        <img src="https://i1.ytimg.com/vi/<?php echo $get_video_id; ?>/hqdefault.jpg" class="img-responsive" />
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                } else {
                                    ?>
                                        <li class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                            <div class="gallery-item">
                                                <div class="gal-item">
                                                    <a class="mfp-img" href="<?php echo base_url('pubs/uploads/'.$gallery->posts_images); ?>" title="<?php echo $gallery->posts_title; ?>" data-source="<?php echo base_url('pubs/uploads/'.$gallery->posts_images); ?>">
                                                        <img src="<?php echo base_url('pubs/uploads/'.$gallery->posts_images); ?>" alt="<?php echo $gallery->posts_title; ?>" />
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                }
                            endforeach;
                        ?>
                    </ul>
                </div>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Example Popup Zoom Gallery
    // --------------------------
    $(document).ready(function() {
        var popup   = $('.popup-gallery');
        var temp    = {};
        var data    = [];
        var n       = 1;
        for (var i = 0 ; i < popup.length ; i++) {
            var typePopup = popup[i].dataset.type;  
            var sourcePopup = popup[i].dataset.source;  

            temp['src']     = sourcePopup,
            temp['type']    = typePopup

            data    = temp;
        }

        console.log(temp);
        console.log(data);

        $('#exampleZoomGallery').magnificPopup({
            delegate: 'a',
            type:'image',
            gallery: {
                enabled: true
            },
            
        });
    });
</script>