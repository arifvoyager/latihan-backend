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
            <li><a href="<?php echo base_url('jpanel/posts'); ?>">Post</a></li>
            <li><a href="<?php echo base_url('jpanel/category'); ?>">Category</a></li>
            
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('jpanel/category/saved'); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation">
                <div class="col-md-12 panel">

                    <!-- Example Tabs Solid -->
                    <div class="example-wrap">
                        <div class="nav-tabs-horizontal nav-tabs-inverse">
                            <?php if(GET_SETTING('multilanguage') == 'Y') { ?>
                                <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                                    <?php
                                        $iLoop = 1;
                                        $GET_LANG = GET_LANG();
                                        foreach($GET_LANG->result() as $rsLang):
                                            if($iLoop == 1) {
                                                $strActive = 'class="active"';
                                            } else {
                                                $strActive = '';
                                            }
                                            ?>
                                                <li <?php echo $strActive; ?> role="presentation">
                                                    <a data-toggle="tab" href="#tab_<?php echo $rsLang->language_code; ?>" aria-controls="tab_<?php echo $rsLang->language_code; ?>" role="tab"><?php echo $rsLang->language_caption; ?> 
                                                        <i class="site-menu-icon" aria-hidden="true"></i></a>
                                                </li>
                                            <?php
                                            $iLoop++;
                                        endforeach;
                                    ?>
                                </ul>
                            <?php } ?>
                            <div class="tab-content">
                                <?php
                                    $iLoop = 1;
                                    $GET_LANG = GET_LANG();
                                    foreach($GET_LANG->result() as $rsLang):
                                        if($iLoop == 1) {
                                            $strActive = 'active';
                                        } else {
                                            $strActive = '';
                                        }
                                        ?>
                                        <div class="tab-pane <?php echo $strActive; ?>" id="tab_<?php echo $rsLang->language_code; ?>" role="tabpanel" style="background-color: #FFF;">
                                            <div class="col-md-12 left-padding" style="padding-top: 20px;">
                                                <div class="col-md-6 left-padding">
                                                    <input type="hidden" name="taxonomy_lang_<?php echo $rsLang->language_code; ?>" id="taxonomy_lang_<?php echo $rsLang->language_code; ?>" value="<?php echo $rsLang->language_code; ?>" />
                                                    <div class="form-group">
                                                        <label class="col-lg-12 col-sm-12 control-label text-left">TAGS <?php if(GET_SETTING('multilanguage') == 'Y') { echo $rsLang->language_flag; } ?></label>
                                                        <div class=" col-lg-12 col-sm-12">
                                                            <input maxlength="50" type="text" class="form-control" name="taxonomy_caption_<?php echo $rsLang->language_code; ?>" id="taxonomy_caption_<?php echo $rsLang->language_code; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-lg-12 col-sm-12 control-label text-left">DESCRIPTION</label>
                                                        <div class="col-lg-12 col-sm-12">
                                                            <textarea class="form-control" name="taxonomy_desc_<?php echo $rsLang->language_code; ?>" id="taxonomy_desc_<?php echo $rsLang->language_code; ?>" rows="3"></textarea>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" class="form-control" name="taxonomy_slug_<?php echo $rsLang->language_code; ?>" id="taxonomy_slug_<?php echo $rsLang->language_code; ?>">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary" id="validateSubmit" style="margin-left: 15px;">Submit</button>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                        <?php
                                        $iLoop++;
                                    endforeach;
                                ?>

                            </div>

                        </div>
                    </div>
                  <!-- End Example Tabs Solid -->

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
    <?php
         $GET_LANG = GET_LANG();
         foreach($GET_LANG->result() as $rsLang):
    ?>
    
    //- SLUG
    $( "#taxonomy_caption_<?php echo $rsLang->language_code; ?>" ).keyup(function() {
        TEXT_DESC = $("#taxonomy_caption_<?php echo $rsLang->language_code; ?>").val();
        TEXT_DESC = TEXT_DESC.replace (/[^a-z0-9]+|\s+/gmi, "-"); 
        TEXT_DESC = TEXT_DESC.toLowerCase();
        
        $("#taxonomy_slug_<?php echo $rsLang->language_code; ?>").val(TEXT_DESC);
    });
    
    <?php endforeach; ?>
    
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
                    
                    <?php
                         $GET_LANG = GET_LANG();
                         foreach($GET_LANG->result() as $rsLang):
                    ?>
                    taxonomy_caption_<?php echo $rsLang->language_code; ?>: {
                        validators: {
                            notEmpty: {
                                message: 'Tags <?php echo $rsLang->language_code; ?> is required'
                            }
                        }
                    },
                    <?php endforeach; ?>
                }
            })
            // Called when a field is invalid
            .on('err.field.fv', function(e, data) {
                // data.element --> The field element

                var $tabPane = data.element.parents('.tab-pane'),
                    tabId    = $tabPane.attr('id');

                $('a[href="#' + tabId + '"][data-toggle="tab"]')
                    .parent()
                    .find('i')
                    .removeClass('wb-check')
                    .addClass('wb-close');
            
                console.log("Error " + tabId);
            
            })
            // Called when a field is valid
            .on('success.field.fv', function(e, data) {
                // data.fv      --> The FormValidation instance
                // data.element --> The field element

                var $tabPane = data.element.parents('.tab-pane'),
                    tabId    = $tabPane.attr('id'),
                    $icon    = $('a[href="#' + tabId + '"][data-toggle="tab"]')
                                .parent()
                                .find('i')
                                .removeClass('wb-check wb-close');

                console.log("Success " + tabId);
            
                // Check if all fields in tab are valid
                var isValidTab = data.fv.isValidContainer($tabPane);
                if (isValidTab !== null) {
                    $icon.addClass(isValidTab ? 'wb-check' : 'wb-close');
                }
            });
    });
    
</script>