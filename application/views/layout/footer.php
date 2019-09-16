<footer>
    <div class="footer-frame">
        <div class="footer-top">
            <div class="footer-info col-xs-12 col-sm-9 col-md-9 col-lg-9">
                <label><?php echo GET_COMPANY('company_name'); ?></label>
                <p><?php echo GET_LABEL('LABEL_ADDRESS', $LANG['code']).' : '.GET_COMPANY('company_address'); ?></p>
                <p><?php echo GET_LABEL('LABEL_TEL', $LANG['code']) .' : '.GET_COMPANY('company_phone').' | '.GET_LABEL('LABEL_FAX', $LANG['code']).' : '.GET_COMPANY('company_fax'); ?></p>
                <p>E-mail : <?php echo GET_COMPANY('company_email'); ?> | Website : <?php echo GET_COMPANY('company_website'); ?></p>
            </div>
            <div class="footer-supported col-xs-12 col-sm-3 col-md-3 col-lg-3">
                <label>Supported By</label>
                <img src="<?php echo base_url('pubs/uploads/images/fordfoundation-logo.png'); ?>" />
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-copyright col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
                <?php echo GET_COMPANY('company_footer'); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding text-right">
                <?php
                    $get_sosmed     = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'social_media', 'taxonomy_value != ' => ''));

                    foreach ($get_sosmed->result() as $sosmed):
                        echo '<a href="'.$sosmed->taxonomy_link.$sosmed->taxonomy_value.'" target="_blank"><i class="fa '.$sosmed->taxonomy_lock_code.'"></i></a>';
                    endforeach;
                ?>
            </div>
        </div>
    </div>
</footer>