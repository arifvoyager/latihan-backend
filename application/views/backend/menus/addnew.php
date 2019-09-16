<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.css"); ?>">

<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a></li>
            <li><a href="#">Apperance</a></li>
            <li><a href="<?php echo base_url('jpanel/menus'); ?>">Menus</a></li>
            
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('jpanel/menus/saved'); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation">
                <div class="col-md-6 panel">

                    <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                            <label class="col-lg-12 col-sm-12 control-label text-left">GROUP MENU</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input maxlength="50" type="text" class="form-control" name="taxonomy_value" id="taxonomy_value">
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
    //- SLUG
    $( "#taxonomy_value" ).keyup(function() {
        TEXT_DESC = $("#taxonomy_value").val();
        TEXT_DESC = TEXT_DESC.replace (/[^a-z0-9]+|\s+/gmi, "-"); 
        TEXT_DESC = TEXT_DESC.toLowerCase();

        $("#taxonomy_slug").val(TEXT_DESC);
    });
    
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
                    
                    taxonomy_caption: {
                        validators: {
                            notEmpty: {
                                message: 'Group menus is required'
                            }
                        }
                    }
                }
            });
    });
    
</script>