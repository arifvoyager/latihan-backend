<!-- Validation Javascript file -->
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/formValidation.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/bootstrap-3.3.4/plugins/validation/js/framework/bootstrap.js'); ?>" type="text/javascript"></script>

<div class="page">
    <div class="page-container page-register">
        <label class="title">Lembar Aplikasi Anggota Perhimpunan Filantropi Indonesia</label>
        <p>Terima kasih atas minat organisasi Anda untuk menjadi anggota Perhimpunan Filantropi Indonesia (PFI). Sebagai sebuah asosiasi nasional pegiat filantropi serta anggota dari asosiasi dan jaringan filantropi global, PFI bekerja untuk memperkuat, mempromosikan dan menyediakan berbagai program dan layanan untuk pengembangan filantropi yang efektif dan berkelanjutan di Indonesia. Untuk menjadi anggota dan bagian dari jaringan PFI, silakan mengisi dan melengkapi formulir di bawah ini dan kemudian mengembalikannya kepada Sekretariat PFI atau e-mail ke informasi@filantropi-indonesia.org. </p>
        
        <label class="sub-title">Informasi Kontak</label>
        <form method="post" class="form-register" id="form-register" enctype="multipart/form-data">
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_NAME', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_name" id="member_name" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_DIRECTUR_NAME', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_directur_name" id="member_directur_name" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_ADDRESS', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_address" id="member_address" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_TELEPHONE', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_telephone" id="member_telephone" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_NAME', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_contact_name" id="member_contact_name" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_POSITION', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_contact_position" id="member_contact_position" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_EMAIL', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="text" class="form-control" name="member_contact_email" id="member_contact_email" />
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
                                    echo '<li><input type="radio" name="member_type" id="member_type" value="'.$members_type->taxonomy_lock_code.'" /> '.$members_type->taxonomy_value.'</li>';
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
                                    echo '<li><input type="radio" name="member_due" id="member_due" value="'.$member_due->taxonomy_lock_code.'" /> '.$member_due->taxonomy_name.' : IDR '.number_format($member_due->taxonomy_value).'</li>';
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="fl-clear"></div>
            </div>
            <div class="register-form">
                <label><?php echo GET_LABEL('LABEL_MEMBER_SIGN', $LANG['code']); ?></label>
                <div class="form-group">
                    <input type="file" class="form-control" name="member_signature" id="member_signature" accept="image/*" />
                </div>
                <div class="fl-clear"></div>
            </div>
            <input type="submit" class="button btn-srad btn-p10 btn-bgred fl-right" value="<?php echo GET_LABEL('BUTTON_SUBMIT', $LANG['code']); ?>" />
            <div class="fl-clear"></div>
            
            <input type="hidden" name="member_slug" id="member_slug" value="" />
        </form>
    </div>
</div>

<script src="<?php echo base_url('assets/sweetalert/sweet-alert.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/sweetalert/sweet-alert.css'); ?>" rel="stylesheet">

<script type="text/javascript">
    $( "#member_name" ).keyup(function() {
        TEXT_DESC = $("#member_name").val();
        TEXT_DESC = TEXT_DESC.replace (/[^a-z0-9]+|\s+/gmi, "-"); 
        TEXT_DESC = TEXT_DESC.toLowerCase();

        $("#member_slug").val(TEXT_DESC);
    });
    
    $(document).ready(function() {
        $('#form-register').formValidation({
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
        .on('success.form.fv', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('member/doregister'); ?>',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    if (data == 'exist_member') {
                        $('#member_contact_email').focus();
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_FAILED_LOGIN', $LANG['code']); ?>",
                                text: "<?php echo GET_LABEL('TEXT_EXIST_CONTACT_EMAIL', $LANG['code']); ?>",
                                type: "error"
                            },
                            function () {
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_contact_email"]').show();
                                $('small[data-fv-validator="notEmpty"][data-fv-for="member_contact_email"]').text('<?php echo GET_LABEL("ERROR_EXIST_CONTACT_EMAIL", $LANG["code"]); ?>');
                            });
                    } else {
                        swal({
                                title: "<?php echo GET_LABEL('LABEL_SUCCESS_REGISTER', $LANG['code']); ?>",
                                text: "<?php echo GET_LABEL('TEXT_SUCCESS_REGISTER', $LANG['code']); ?>",
                                type: "success"
                            },
                            function () {
                                window.location.href = BASE_URL;
                            });
                    }
                }
            });
        });        
    });    
    
    //CAPTCHA ---------------------------------------------------------------------------------------------------
    var captchaTemp = Math.floor((Math.random() * 10000) + 1);
    $("#captcha").val(captchaTemp);
    
</script>