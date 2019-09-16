<?php
    $get_member_type    = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_cat', 'taxonomy_lock_code' => $member_detail->member_type, 'taxonomy_lang' => $LANG['code']))->row();
    $get_member_due     = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_due', 'taxonomy_lock_code' => $member_detail->member_due, 'taxonomy_lang' => $LANG['code']))->row();

    if ($member_detail->member_logo != '') {
        $member_logo        = 'pubs/uploads/'.$member_detail->member_logo;
    } else {
        $member_logo        = 'pubs/uploads/images/NoLogo.jpg';
    }

?>

<div class="member-detail-desc">
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_NAME', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_name; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_DIRECTUR_NAME', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_directur_name; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_ADDRESS', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_address; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_TELEPHONE', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_telephone; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_NAME', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_contact_name; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_POSITION', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_contact_position; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_EMAIL', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $member_detail->member_contact_email; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_TYPE', $LANG['code']); ?></label>
        <label class="label-right"><?php echo $get_member_type->taxonomy_value; ?></label>
        <div class="fl-clear"></div>
    </div>
    <div class="member-detail-list">
        <label class="label-left"><?php echo GET_LABEL('LABEL_MEMBER_DUE', $LANG['code']); ?></label>
        <label class="label-right"><?php echo 'IDR '.number_format($get_member_due->taxonomy_value).'/'.$get_member_due->taxonomy_name; ?></label>
        <div class="fl-clear"></div>
    </div>

    <div class="member-profile">
        <div class="member-profile-desc">
            <label class="title"><?php echo GET_LABEL('TITLE_PROFILE', 'id').' '.GET_LANG_FLAG('id'); ?></label>
            <?php echo $member_detail->member_profile_id; ?>
        </div>
        <div class="member-profile-desc right">
            <label class="title"><?php echo GET_LABEL('TITLE_PROFILE', 'en').' '.GET_LANG_FLAG('en'); ?></label>
            <?php echo $member_detail->member_profile_en; ?>
        </div>
        <div class="fl-clear"></div>
    </div>
</div>
<div class="member-detail-picture">
    <img class="img-responsive" src="<?php echo base_url($member_logo); ?>" />
</div>
<div class="fl-clear"></div>