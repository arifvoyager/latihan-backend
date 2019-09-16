<!-- Validation Javascript file -->
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/formValidation.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/framework/bootstrap.js'); ?>" type="text/javascript"></script>

<div class="page">
    <div class="page-container page-register">
        <label class="title"><?php echo GET_LABEL('TITLE_LOGIN_PAGE', $LANG['code']); ?></label>
        <div class="login-frame">
            <form method="post" name="formLogin" id="formLogin">
                <div class="form-group input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <input autocomplete="off" type="text" class="form-control" id="member_username" placeholder="<?php echo GET_LABEL('PLACEHOLDER_USERNAME', $LANG['code']); ?>" name="member_username">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="member_password" placeholder="<?php echo GET_LABEL('PLACEHOLDER_PASSWORD', $LANG['code']); ?>" name="member_password">
                </div>
                <div class="form-group">
                    <input type="text" name="captcha" id="captchaLogin" class="captcha text-center form-control" disabled>
                    <input autocomplete="off" type="text" class="captcha form-control text-center" name="captcha_text" id="textedit5" maxlength="5" placeholder="<?php echo GET_LABEL('LABEL_INPUT_CAPTCHA', $LANG['code']); ?>">
                    <input type="button" name="btnReloadCaptcha" id="btnReloadCaptchaLogin" value="&nbsp;" class="btnReload">
                    <label class="button btn-srad btn-bgblue btn-p10 fl-right" onclick="$('#formLogin').submit();"><?php echo GET_LABEL('BUTTON_LOGIN', $LANG['code']); ?></label>
                    <!--<input type="submit" class="button btn-bgblue btn-pt10 fl-right" value="<?php echo GET_LABEL('BUTTON_LOGIN', $LANG['code']); ?>" />-->
                    <div class="fl-clear"></div>
                </div>
                <div class="form-group clearfix">
                    <div class="checkbox-custom checkbox-inline pull-left">
                    </div>
                    <a class="pull-right" href="<?php echo base_url("jpanel/cpanelx/resetpassword"); ?>"><?php echo GET_LABEL('LABEL_FORGOT_PASSWORD', $LANG['code']); ?></a>
                </div>
                <div class="fl-clear"></div>
            </form>
        </div>
    </div>
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
        $('#formLogin').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                member_username: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL("ERROR_EMPTY_USERNAME", $LANG["code"]); ?>'
                        }
                    }
                },
                member_password: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo GET_LABEL("ERROR_EMPTY_PASSWORD", $LANG["code"]); ?>'
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
                url: '<?php echo base_url('member/dologin'); ?>',
                data: $('#formLogin').serialize(),
                success: function(data){
                    console.log(data);
                    if (data == 'not_exist_member') {
                        $('#member_username').focus();
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_FAILED_LOGIN', $LANG['code']); ?>",
                                text: "<?php echo GET_LABEL('TEXT_NOT_EXIST_MEMBER', $LANG['code']); ?>",
                                type: "error"
                            },
                            function () {
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_username"]').show();
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_username"]').text('<?php echo GET_LABEL("ERROR_NOT_EXIST_USERNAME", $LANG["code"]); ?>');
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
                    } else if (data == 'not_activated_member') {
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_FAILED_LOGIN', $LANG['code']); ?>",
                                text: "<?php echo GET_LABEL('TEXT_NOT_ACTIVATED', $LANG['code']); ?>",
                                type: "error"
                            },
                            function () {
                                //window.location.href = BASE_URL;
                            });
                    } else if (data == 'login_success') {
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_SUCCESS_LOGIN', $LANG['code']); ?>",
                                type: "success"
                            },
                            function () {
                                window.location.href = BASE_URL+"member";
                            });
                    }
                    //window.location.href = BASE_URL+"member";
                }
            });
        });
    });    
</script>