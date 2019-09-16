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
            <form action="<?php echo base_url('jpanel/setting/saved'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" name="frmaddnew" id="frmvalidation">
                
                <div class="col-md-8">
                    
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">COMPANY INFO</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            
                            <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">COMPANY NAME</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo GET_COMPANY('company_name'); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">COMPANY ABOUT</label>
                            <div class=" col-lg-12 col-sm-12">
                                <textarea class="form-control" name="company_about" id="company_about"><?php echo GET_COMPANY('company_about'); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class=" col-lg-6 col-sm-6" style="padding: 0px;">
                                <label class="col-lg-12 col-sm-12 control-label text-left">PHONE</label>
                                <div class=" col-lg-12 col-sm-12">
                                    <input type="text" class="form-control" name="company_phone" id="company_phone" value="<?php echo GET_COMPANY('company_phone'); ?>">
                                </div>
                            </div>
                            <div class=" col-lg-6 col-sm-6" style="padding: 0px;">
                                <label class="col-lg-12 col-sm-12 control-label text-left">FAX</label>
                                <div class=" col-lg-12 col-sm-12">
                                    <input type="text" class="form-control" name="company_fax" id="company_fax" value="<?php echo GET_COMPANY('company_fax'); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">EMAIL</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input type="text" class="form-control" name="company_email" id="company_email" value="<?php echo GET_COMPANY('company_email'); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">WEBSITE</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input type="text" class="form-control" name="company_website" id="company_website" value="<?php echo GET_COMPANY('company_website'); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">ADDRESS</label>
                            <div class=" col-lg-12 col-sm-12">
                                <textarea rows="3" maxlength="500" type="text" class="form-control" name="company_address" id="company_address"><?php echo GET_COMPANY('company_address'); ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class=" col-lg-6 col-sm-6" style="padding: 0px;">
                                <label class="col-lg-12 col-sm-12 control-label text-left">LATITUDE</label>
                                <div class=" col-lg-12 col-sm-12">
                                    <input type="text" class="form-control" name="company_latitude" id="company_latitude" value="<?php echo GET_COMPANY('company_latitude'); ?>">
                                </div>
                            </div>
                            <div class=" col-lg-6 col-sm-6" style="padding: 0px;">
                                <label class="col-lg-12 col-sm-12 control-label text-left">LONGITUDE</label>
                                <div class=" col-lg-12 col-sm-12">
                                    <input type="text" class="form-control" name="company_longitude" id="company_longitude" value="<?php echo GET_COMPANY('company_longitude'); ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                            
                        </div>
                    </div>

                </div>
                
                <div class="col-md-4" style="padding-right: 0px;">
                    
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">COMPANY LOGO</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <img src="<?php echo base_url('pubs/uploads/'.GET_COMPANY('company_logo')); ?>" class="img-responsive img-rounded" style="border: 1px solid #ccc; margin: 0 auto;">
                                <input type="hidden" class="form-control" name="company_logo_temp" id="company_logo_temp" value="<?php echo GET_COMPANY('company_logo'); ?>">
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                <div class="input-group input-group-file">
                                    <input type="text" class="form-control" id="company_logo_fname" name="company_logo_fname">
                                    <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="company_logo" id="company_logo">
                                        </span>
                                    </span>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">ADDITIONAL</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-lg-12 col-sm-12 control-label text-left">GOOGLE ANALYTICS</label>
                                <div class=" col-lg-12 col-sm-12">
                                    <textarea rows="3" maxlength="500" type="text" class="form-control" name="google_analytics" id="google_analytics"><?php echo GET_COMPANY('google_analytics'); ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="col-lg-12 col-sm-12 control-label text-left">FOOTER</label>
                                    <input type="text" class="form-control" name="company_footer" id="company_footer" value="<?php echo GET_COMPANY('company_footer'); ?>">
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