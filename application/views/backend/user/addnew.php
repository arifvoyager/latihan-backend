<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.css"); ?>">

<style type="text/css">
    
    .left-padding {
        padding-left: 0px;    
    }
    
    .right-padding {
        padding-right: 0px;    
    }
    
    .panel-heading {
        height: 45px;   
    }
    
    .panel-title {
        height: 44px;  
        padding-top: 13px;
    }
    
    .panel-actions {
        margin-right: -15px;    
    }
    
    .nav-tabs a {
        border-radius: 0px !important;   
    }
    
</style>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('jpanel/user'); ?>">User</a></li>
            
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('jpanel/user/saved'); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation" enctype="multipart/form-data">
                <div class="col-md-7 panel">

                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">ALIAS NAME</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input maxlength="50" type="text" class="form-control" name="userlogin_aliasname" id="userlogin_aliasname">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">EMAIL</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input type="text" class="form-control" name="userlogin_email" id="userlogin_email">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">USERNAME</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input maxlength="50" type="text" class="form-control" name="userlogin_username" id="userlogin_username">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">PASSWORD</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input maxlength="50" type="text" class="form-control" name="userlogin_passwd" id="userlogin_passwd">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">AVATAR</label>
                            <div class=" col-lg-12 col-sm-12">
                                <div class="input-group input-group-file">
                                    <input type="text" class="form-control" id="userlogin_avatar_fname" name="userlogin_avatar_fname">
                                    <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="userlogin_avatar" id="userlogin_avatar" accept="image/*">
                                        </span>
                                    </span>
                                </div>
                                <small>Image size : 200px x 200px</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">PUBLISH</label>
                            <div class=" col-lg-12 col-sm-12">
                                <ul class="list-unstyled list-inline">
                                    <li class="margin-right-25 margin-bottom-25">
                                        <input type="checkbox" name="userlogin_status" class="js-switch-small" value="Y" data-plugin="switchery" data-size="small" checked />
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>
                
                <div class="col-md-7 panel">
                    <div class="form-group text-right" style="padding-top: 20px; padding-right: 20px;">
                        <button type="submit" class="btn btn-primary" id="validateSubmit" style="margin-left: 15px;">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/formvalidation/framework/bootstrap.min.js"); ?>"></script>
<script type="text/javascript">
    
    $(document).ready(function() {
        $('#frmvalidation')
            .formValidation({
                framework: 'bootstrap',
                // Only disabled elements are excluded
                // The invisible elements belonging to inactive tabs must be validated
                excluded: [':disabled'],
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    userlogin_aliasname: {
                        validators: {
                            notEmpty: {
                                message: 'Aliasname is required'
                            }
                        }
                    },
                    userlogin_email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The email address is not valid'
                            }
                        }
                    },
                    userlogin_username: {
                        validators: {
                            notEmpty: {
                                message: 'Username is required'
                            }
                        }
                    },
                    userlogin_passwd: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    },
                    userlogin_avatar: {
                        validators: {
                            notEmpty: {
                                message: 'Avatar is required'
                            }
                        }
                    },
                }
            });
    });
    
    $('#userlogin_avatar').change(function() {
        var filename = $('#userlogin_avatar').val();
        $('#userlogin_avatar_fname').val(filename);
    });
    
    
</script>