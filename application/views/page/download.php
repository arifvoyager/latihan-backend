<?php
    $uri_slug           = $this->uri->segment(2);

    $get_category       = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'download_cat', 'taxonomy_lang' => $LANG['code']));
    $category_download  = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'download_cat', 'taxonomy_slug' => $uri_slug, 'taxonomy_lang' => $LANG['code']))->row();

    if ($uri_slug == false) {
        $get_download   = $this->db->get_where('cd_posts', array('posts_type' => 'download', 'posts_lang' => $LANG['code']));
    } else {
        $get_download   = $this->db->get_where('cd_posts', array('posts_type' => 'download', 'posts_category' => $category_download->taxonomy_lock_code, 'posts_lang' => $LANG['code']));
    }
?>

<div class="page">
    <div class="page-container page-download">
        <label class="title"><?php echo $pages->posts_subtitle; ?></label>
        <div class="download-category">
            <?php
                foreach ($get_category->result() as $category) :
                    if ($category->taxonomy_slug == $uri_slug) {
                        $active     = ' active';
                    } else {
                        $active     = '';
                    }
                    ?>
                        <div class="dc-item col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="dc-box <?php echo $active; ?>" onclick="javascript:location.href='<?php echo base_url($this->uri->segment(1).'/'.$category->taxonomy_slug); ?>'">
                                <?php echo $category->taxonomy_value; ?>
                            </div>
                        </div>
                    <?php
                endforeach;
            ?>
            <div class="fl-clear"></div>
        </div>
        <div class="download-item">
            <?php 
                foreach ($get_download->result() as $download) :
                    if($this->session->userdata('sess_member_fi') == false){
                        if ($download->posts_visibility == 'M') {
                            $download_link  = "javascript:swal({ title: '".GET_LABEL('LABEL_ONLY_MEMBERS', $LANG['code'])."',text: '".GET_LABEL('TEX_ONLY_MEMBER', $LANG['code'])."',type: 'error'}, function () { window.location.href = BASE_URL+'member/login'; })";
                        } else {
                            $download_link  = base_url('pubs/file/'.$download->posts_file);
                        }
                    } else {
                        $download_link  = base_url('pubs/file/'.$download->posts_file);
                    }
                    ?>
                        <div class="di-item col-md-4">
                            <div class="di-box">
                                <div class="di-box-image">
                                    <img src="<?php echo base_url('pubs/uploads/images/'.$download->posts_images); ?>" class="img-responsive" />
                                </div>
                                <div class="di-box-button">
                                    <label><?php echo $download->posts_title; ?></label>
                                    <a href="<?php echo $download_link; ?>" target="_blank">
                                        <i class="fa fa-cloud-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php
                endforeach;
            ?>
            <div class="fl-clear"></div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/sweetalert/sweet-alert.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/sweetalert/sweet-alert.css'); ?>" rel="stylesheet">
