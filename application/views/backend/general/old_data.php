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
            <li><a href="#">Apperance</a></li>
            
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('jpanel/general/saved'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" name="frmaddnew" id="frmvalidation">
                
                <div class="col-md-4">
                    
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">PRODUCT IMAGE SIZE</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="col-lg-12 col-sm-12 control-label text-left" style="padding-left: 0px;">WIDTH</label>
                                    <input type="text" class="form-control" name="product_width" id="product_width" value="<?php echo GET_COMPANY('product_width'); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="col-lg-12 col-sm-12 control-label text-left" style="padding-left: 0px;">HEIGHT</label>
                                    <input type="text" class="form-control" name="product_height" id="product_height" value="<?php echo GET_COMPANY('product_height'); ?>">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-12 panel">
                        <div class="form-group text-right" style="padding-top: 20px; padding-right: 20px;">
                            <button type="submit" class="btn btn-primary" id="validateSubmit" style="margin-left: 15px;">Submit</button>
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-md-4">
                    
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">SLIDER IMAGE SIZE</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="col-lg-12 col-sm-12 control-label text-left" style="padding-left: 0px;">WIDTH</label>
                                    <input type="text" class="form-control" name="slider_width" id="slider_width" value="<?php echo GET_COMPANY('slider_width'); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="col-lg-12 col-sm-12 control-label text-left" style="padding-left: 0px;">HEIGHT</label>
                                    <input type="text" class="form-control" name="slider_height" id="slider_height" value="<?php echo GET_COMPANY('slider_height'); ?>">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-12 panel">
                        <div class="form-group text-right" style="padding-top: 20px; padding-right: 20px;">
                            <button type="submit" class="btn btn-primary" id="validateSubmit" style="margin-left: 15px;">Submit</button>
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-md-4">
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">MULTI LANGUAGE</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <label class="col-md-3">No</label>
                            <div class="col-md-3 right-padding">
                                <ul class="list-unstyled list-inline">
                                    <li class="margin-right-25 margin-bottom-25">
                                        <input type="checkbox" name="multilanguage" class="js-switch-small" value="Y" data-plugin="switchery" data-size="small" <?php if(GET_COMPANY('multilanguage') == 'Y') { echo 'checked'; } ?> />
                                    </li>
                                </ul>
                            </div>
                            <label class="col-md-3">Yes</label>
                            <div class="col-md-12 col-lg-12 form-group text-right" style="padding-top: 20px; padding-right: 20px;">
                                <button type="submit" class="btn btn-primary" id="validateSubmit" style="margin-left: 15px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/backend/js/components/panel.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/select2/select2.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/bootstrap-select/bootstrap-select.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/js/components/bootstrap-select.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/formvalidation/framework/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/js/components/tabs.js"); ?>"></script>
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
                    
                    company_name: {
                        validators: {
                            notEmpty: {
                                message: 'Company Name is required'
                            }
                        }
                    }
                }
        });
        
    });
    
    $('#company_logo').change(function() {
        var filename = $('#company_logo').val();
        $('#company_logo_fname').val(filename);
    });
    
</script>