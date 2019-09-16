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
            <li><a href="<?php echo base_url('jpanel/gallery'); ?>">Gallery</a></li>
            <li><a href="<?php echo base_url('jpanel/gallery/data/photo'); ?>">Photo</a></li>
            
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('jpanel/gallery/saved/gallery_video'); ?>" enctype="multipart/form-data" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation">
                <div class="col-md-6 panel">

                    <div class="col-md-12 left-padding">
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">SORT</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input maxlength="3" type="text" class="form-control" name="posts_sort" id="posts_sort">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">VIDEO LINK</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input type="text" class="form-control" name="posts_link" id="posts_link">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="validateSubmit" style="margin-left: 15px;">Submit</button>
                        </div>

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
                    posts_sort: {
                        validators: {
                            notEmpty: {
                                message: 'Image sort is required'
                            },
                            integer: {
                                message: 'The value is not an number'
                            }
                        }
                    },
                    
                    posts_link: {
                        validators: {
                            notEmpty: {
                                message: 'Image file is required'
                            }
                        }
                    },
                }
            });
    });
</script>