<!-- Validation Javascript file -->
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/formValidation.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/framework/bootstrap.js'); ?>" type="text/javascript"></script>

<?php
    if ($member_detail->member_logo != '') {
        $member_logo        = 'pubs/uploads/'.$member_detail->member_logo;
    } else {
        $member_logo        = 'pubs/uploads/images/NoLogo.jpg';
    }
?>
<div class="page-register">
    <form method="post" action="<?php echo base_url('member/do_update'); ?>" class="form-update" id="form-update" enctype="multipart/form-data">
        <div class="member-detail-desc">    
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_NAME', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo $member_detail->member_name; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_DIRECTUR_NAME', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_directur_name" id="member_directur_name" value="<?php echo $member_detail->member_directur_name; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_ADDRESS', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_address" id="member_address" value="<?php echo $member_detail->member_address; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_TELEPHONE', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_telephone" id="member_telephone" value="<?php echo $member_detail->member_telephone; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_NAME', $LANG['code']); ?></label>
                 <div class="form-group">
                    <input type="text" class="form-control" name="member_contact_name" id="member_contact_name" value="<?php echo $member_detail->member_contact_name; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_POSITION', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_contact_position" id="member_contact_position" value="<?php echo $member_detail->member_contact_position; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_EMAIL', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_contact_email" id="member_contact_email" value="<?php echo $member_detail->member_contact_email; ?>" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_TYPE', $LANG['code']); ?></label>
                <div class="form-group">
                    <div class="member-type">
                        <ul>
                            <?php
                                $get_members_type       = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_cat', 'taxonomy_lang' => $LANG['code']));

                                foreach ($get_members_type->result() as $members_type) :
                                    if ($member_detail->member_type == $members_type->taxonomy_lock_code) { 
                                        $checked_type    = 'checked="checked"';
                                    } else {
                                        $checked_type    = '';
                                    }

                                    echo '<li><input type="radio" name="member_type" id="member_type" value="'.$members_type->taxonomy_lock_code.'" '.$checked_type.' /> '.$members_type->taxonomy_value.'</li>';
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_DUE', $LANG['code']); ?></label>
                <div class="form-group">
                    <div class="member-type">
                        <ul>
                            <?php
                                $get_member_due       = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_due', 'taxonomy_lang' => $LANG['code']));

                                foreach ($get_member_due->result() as $member_due) :
                                    if ($member_detail->member_due == $member_due->taxonomy_lock_code) { 
                                        $checked_due    = 'checked="checked"';
                                    } else {
                                        $checked_due    = '';
                                    }

                                    echo '<li><input type="radio" name="member_due" id="member_due" value="'.$member_due->taxonomy_lock_code.'" '.$checked_due.' /> '.$member_due->taxonomy_name.' : IDR '.number_format($member_due->taxonomy_value).'</li>';
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form full-width">
                <label><?php echo GET_LABEL('LABEL_PROFILE', 'id').' '.GET_LANG_FLAG('id'); ?></label>
                <div class="form-group">
                    <textarea class="form-control" name="member_profile_id" id="member_profile_id"><?php echo $member_detail->member_profile_id; ?></textarea>
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form full-width">
                <label><?php echo GET_LABEL('LABEL_PROFILE', 'en').' '.GET_LANG_FLAG('en'); ?></label>
                <div class="form-group">
                    <textarea class="form-control" name="member_profile_en" id="member_profile_en"><?php echo $member_detail->member_profile_en; ?></textarea>
                </div>
                <div class="fl-clear"></div>
            </div>
            <input type="submit" class="button btn-srad btn-p10 btn-bgred fl-right" value="<?php echo GET_LABEL('BUTTON_SUBMIT', $LANG['code']); ?>" />
            <div class="fl-clear"></div>

            <input type="hidden" name="member_slug" id="member_slug" value="<?php echo $member_detail->member_slug; ?>" />
            <input type="hidden" name="member_uid" id="member_uid" value="<?php echo $member_detail->member_uid; ?>" />
        </div>
        <div class="member-detail-picture">
            <img class="img-responsive" src="<?php echo base_url($member_logo); ?>" />
            <input type="file" class="form-control" name="member_logo" id="member_logo" accept="image/*" />
        </div>
        <div class="fl-clear"></div>
    </form>
</div>

<script src="<?php echo base_url('assets/sweetalert/sweet-alert.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/sweetalert/sweet-alert.css'); ?>" rel="stylesheet">

<script src="<?php echo base_url("assets/ckeditor_4.5.3/ckeditor.js"); ?>"></script>

<script type="text/javascript">
    $( "#member_name" ).keyup(function() {
        TEXT_DESC = $("#member_name").val();
        TEXT_DESC = TEXT_DESC.replace (/[^a-z0-9]+|\s+/gmi, "-"); 
        TEXT_DESC = TEXT_DESC.toLowerCase();

        $("#member_slug").val(TEXT_DESC);
    });
    
    CKEDITOR.replace($('#member_profile_id').attr('name'), {
        height: 300,
        filebrowserBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=files',
        filebrowserUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=files',
        filebrowserImageBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=images',
        filebrowserFlashBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=flash',
        filebrowserImageUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=images',
        filebrowserFlashUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=flash',
        customConfig: BASE_URL + '/assets/ckeditor_4.5.3/config.js'
    });
    CKEDITOR.replace($('#member_profile_en').attr('name'), {
        height: 300,
        filebrowserBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=files',
        filebrowserUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=files',
        filebrowserImageBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=images',
        filebrowserFlashBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=flash',
        filebrowserImageUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=images',
        filebrowserFlashUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=flash',
        customConfig: BASE_URL + '/assets/ckeditor_4.5.3/config.js'
    });
    
    $(document).ready(function() {
        $('#form-update').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                member_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_NAME', $LANG['code']); ?>'
                        }
                    }
                },
                member_directur_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_DIRECTUR_NAME', $LANG['code']); ?>'
                        }
                    }
                },
                member_address: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_ADDRESS', $LANG['code']); ?>'
                        }
                    }
                },
                member_telephone: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_TELEPHONE', $LANG['code']); ?>'
                        }
                    }
                },
                member_contact_name: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_CONTACT_NAME', $LANG['code']); ?>'
                        }
                    }
                },
                member_contact_position: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_CONTACT_POSITION', $LANG['code']); ?>'
                        }
                    }
                },
                member_contact_email: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_CONTACT_EMAIL', $LANG['code']); ?>'
                        },
                        emailAddress: {
                            message: '<?php echo GET_LABEL('ERROR_FORMAT_EMAIL', $LANG['code']); ?>'
                        }
                    }
                },
                member_type: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_MEMBER_TYPE', $LANG['code']); ?>'
                        }
                    }
                },
                member_due: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL('ERROR_EMPTY_MEMBER_DUE', $LANG['code']); ?>'
                        }
                    }
                }
            }
        })     
    });     
</script>