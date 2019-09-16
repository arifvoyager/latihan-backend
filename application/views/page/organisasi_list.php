<?php
    $organisasi_cate        = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_cat', 'taxonomy_lang' => $LANG['code']));
    
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
                    foreach ($organisasi_cate->result() as $org_cate):
                        $get_organisasi              = $this->db->get_where('cd_member', array('member_type' => $org_cate->taxonomy_lock_code, 'member_status' => 'Active', 'member_super' => 'N'));

                        if ($get_organisasi->num_rows() > 0) {
                            echo '<label class="title">'.$org_cate->taxonomy_value.'</label>';
                            echo '<div class="mitra-list col-xs-12 col-sm-12 col-md-12 col-lg-12">';

                            foreach ($get_organisasi->result() as $organisasi) :
                                if ($organisasi->member_logo != '') {
                                    $organisasi_logo        = 'pubs/uploads/'.$organisasi->member_logo;
                                } else {
                                    $organisasi_logo        = 'pubs/uploads/images/NoLogo.jpg';
                                }

                                echo '<div class="mitra-item col-xs-6 col-sm-3 col-md-3 col-lg-3">';
                                echo '  <a href="'.base_url($this->uri->segment(1).'/profile/'.$organisasi->member_slug).'">';
                                echo '  <div class="mi-item">';
                                echo '      <div class="mitra-item-image">';
                                echo '          <img class="img-responsive" src="'.base_url($organisasi_logo).'" />';
                                echo '      </div>';
                                echo '      <span>'.$organisasi->member_name.'</span>';
                                echo '  </div>';
                                echo '  </a>';
                                echo '</div>';
                            endforeach;
                            echo '  <div class="fl-clear"></div>';
                            echo '</div>';
                        }
                    endforeach;
                ?>
                <div class="fl-clear"></div>
            </div>
        </div>
    </div>
</div>