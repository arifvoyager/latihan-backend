<!-- Validation Javascript file -->
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/formValidation.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/framework/bootstrap.js'); ?>" type="text/javascript"></script>

<div class="change-password">
    <form action="post" name="form-change" id="form-change">
        <div class="form-group input-group">
            <span class="input-group-addon">
                <i class="fa fa-lock"></i>
            </span>
            <input type="password" class="form-control" id="member_old_password" placeholder="<?php echo GET_LABEL('PLACEHOLDER_OLD_PASSWORD', $LANG['code']); ?>" name="member_old_password">
        </div>
        <div class="form-group input-group">
            <span class="input-group-addon">
                <i class="fa fa-lock"></i>
            </span>
            <input type="password" class="form-control" id="member_new_password" placeholder="<?php echo GET_LABEL('PLACEHOLDER_NEW_PASSWORD', $LANG['code']); ?>" name="member_new_password">
        </div>
        <div class="form-group input-group">
            <span class="input-group-addon">
                <i class="fa fa-lock"></i>
            </span>
            <input type="password" class="form-control" id="re_member_new_password" placeholder="<?php echo GET_LABEL('PLACEHOLDER_RE_NEW_PASSWORD', $LANG['code']); ?>" name="re_member_new_password">
        </div>
        <div class="form-group">
            <input type="text" name="captcha" id="captchaLogin" class="captcha text-center form-control" disabled>
            <input autocomplete="off" type="text" class="captcha form-control text-center" name="captcha_text" id="textedit5" maxlength="5" placeholder="<?php echo GET_LABEL('LABEL_INPUT_CAPTCHA', $LANG['code']); ?>">
            <input type="button" name="btnReloadCaptcha" id="btnReloadCaptchaLogin" value="&nbsp;" class="btnReload">
            <label class="button btn-srad btn-bgblue btn-p12 fl-right" onclick="$('#form-change').submit();"><?php echo GET_LABEL('BUTTON_CHANGE', $LANG['code']); ?></label>
            <!--<input type="submit" class="button btn-bgblue btn-pt10 fl-right" value="<?php echo GET_LABEL('BUTTON_CHANGE', $LANG['code']); ?>" />-->
            <div class="fl-clear"></div>
        </div>
    </form> 
</div>

<script src="<?php echo base_url('assets/sweetalert/sweet-alert.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/sweetalert/sweet-alert.css'); ?>" rel="stylesheet">

<script type="text/javascript">
    //CAPTCHA FOR LOGIN FORM ------------------------------------------------------------------------------
    var captchaTempLogin = Math.floor((Math.random() * 10000) + 1);
    $("#captchaLogin").val(captchaTempLogin);

    $("#btnReloadCaptchaLogin").click(function(){
        var captchaTempLogin = Math.floor((Math.random() * 10000) + 1);
        $("#captchaLogin").val(captchaTempLogin);
    });

    $(document).ready(function() {
        $('#form-change').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                member_old_password: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL("ERROR_EMPTY_OLD_PASSWORD", $LANG["code"]); ?>'
                        }
                    }
                },
                member_new_password: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL("ERROR_EMPTY_NEW_PASSWORD", $LANG["code"]); ?>'
                        }
                    }
                },
                re_member_new_password: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL("ERROR_EMPTY_RE_NEW_PASSWORD", $LANG["code"]); ?>'
                        },
                        identical: {
                            field: 'member_new_password',
                            message: '<?php echo GET_LABEL("ERROR_NOT_SAME_PASSWORD", $LANG["code"]); ?>'
                        }                        
                    }
                },
                captcha_text: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL("ERROR_EMPTY_CAPTCHA", $LANG["code"]); ?>'
                        },
                        identical: {
                            field: 'captcha',
                            message: '<?php echo GET_LABEL("ERROR_NOT_SAME_CAPTCHA", $LANG["code"]); ?>'
                        }
                    }
                }
            }
        })
        .on('success.form.fv', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('member/dochange'); ?>',
                data: $('#form-change').serialize(),
                success: function(data){
                    if (data == 'not_match_password') {
                        $('#member_old_password').focus();
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_FAILED_CHANGE', $LANG['code']); ?>",
                                text: "<?php echo GET_LABEL('TEXT_NOT_MATCH_OLD_PASSWORD', $LANG['code']); ?>",
                                type: "error"
                            },
                            function () {
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_old_password"]').show();
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_old_password"]').text('<?php echo GET_LABEL("ERROR_NOT_MATCH_OLD_PASSWORD", $LANG["code"]); ?>');
                            });
                    } else if (data == 'not_match_login') {
                        $('#member_username').focus();
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_FAILED_LOGIN', $LANG['code']); ?>",
                                text: "<?php echo GET_LABEL('TEXT_NOT_MATCH_LOGIN', $LANG['code']); ?>",
                                type: "error"
                            },
                            function () {
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_username"]').show();
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_username"]').text('<?php echo GET_LABEL("ERROR_NOT_MATCH_LOGIN", $LANG["code"]); ?>');
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_password"]').show();
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_password"]').text('<?php echo GET_LABEL("ERROR_NOT_MATCH_LOGIN", $LANG["code"]); ?>');
                            });
                    } else if (data == 'change_success') {
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_SUCCESS_CHANGE', $LANG['code']); ?>",
                                type: "success"
                            },
                            function () {
                                window.location.href = BASE_URL+"member";
                            });
                    }
                }
            });
        });
    });    
</script>