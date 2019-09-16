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
            <li><a href="<?php echo base_url('cms'); ?>">Home</a></li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('jpanel/sosmed/saved'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" name="frmaddnew" id="frmvalidation">
                
                <div class="col-md-8">
                    
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">Social Media</h4>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12" style="padding: 0;">
                                
                                <?php
                                    foreach ($sosmed->result() as $result) :
                                        ?>
                                            <div class="form-group">
                                                <label class="col-lg-12 col-sm-12 control-label text-left"><?php echo $result->taxonomy_name; ?></label>
                                                <div class=" col-lg-12 col-sm-12">
                                                    <input type="text" class="form-control" name="taxonomy_value_<?php echo $result->taxonomy_slug; ?>" id="taxonomy_value_<?php echo $result->taxonomy_slug; ?>" value="<?php echo $result->taxonomy_value; ?>">
                                                </div>
                                            </div>
                                        <?php
                                    endforeach;
                                ?>
                            </div>
                            
                        </div>
                        
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Submit</button>
                        </div>

                    </div>

                </div>
                
                

            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/backend/js/components/panel.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/js/components/bootstrap-select.js"); ?>"></script>
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
    
</script>