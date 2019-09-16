<div class="page">
    <div class="page-container page-download">
        <label class="title"><?php echo GET_LABEL('TITLE_MEMBER_AREA', $LANG['code']); ?></label>
        
        <div class="member-category">
            <label class="button btn-bgred btn-srad btn-p10 <?php if ($uri_page == '' || $uri_page == 'profile') { echo 'active'; } ?>" onclick="javscript:location.href='<?php echo base_url('member/profile'); ?>'"><?php echo GET_LABEL('BUTTON_MY_PROFILE', $LANG['code']); ?></label>
            <label class="button btn-bgred btn-srad btn-p10 <?php if ($uri_page == 'edit_profile') { echo 'active'; } ?>" onclick="javscript:location.href='<?php echo base_url('member/edit_profile'); ?>'"><?php echo GET_LABEL('BUTTON_EDIT_PROFILE', $LANG['code']); ?></label>
            <label class="button btn-bgred btn-srad btn-p10 <?php if ($uri_page == 'change_password') { echo 'active'; } ?>" onclick="javscript:location.href='<?php echo base_url('member/change_password'); ?>'"><?php echo GET_LABEL('BUTTON_CHANGE_PASSWORD', $LANG['code']); ?></label>
            <label class="button btn-bggrey btn-srad btn-p10" onclick="javscript:location.href='<?php echo base_url('member/dologout'); ?>'"><?php echo GET_LABEL('BUTTON_LOGOUT', $LANG['code']); ?></label>
        </div>
        <div class="member-detail">
            <?php echo $this->load->view($content_member); ?>
        </div>
    </div>
</div>