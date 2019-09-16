<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/ckeditor_4.5.3/toolbarconfigurator/lib/codemirror/neo.css"); ?>">

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
            <li><a href="<?php echo base_url('cms/cpanelx'); ?>">Home</a></li>
            <li class="active">
                <a href="<?php echo base_url('cms/slider'); ?>">Slider</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
        <form action="<?php echo base_url('cms/slider/saved'); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation" enctype="multipart/form-data">
            <div class="col-md-7 panel left-padding">
                <!-- Example Tabs Solid -->
                <div class="example-wrap">
                    <div class="nav-tabs-horizontal nav-tabs-inverse">                
                        <?php if(GET_COMPANY('multilanguage') == 'Y') { ?>
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
                                <div class="col-md-12" style="padding-top: 20px;">
                                    <input type="hidden" name="posts_lang_<?php echo $rsLang->language_code; ?>" id="posts_lang_<?php echo $rsLang->language_code; ?>" value="<?php echo $rsLang->language_code; ?>" />
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">TITLE</label>
                                        <div class=" col-lg-12 col-sm-12">
                                            <input type="text" class="form-control" name="posts_title_<?php echo $rsLang->language_code; ?>" id="posts_title_<?php echo $rsLang->language_code; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">SHORT DESCRIPTION</label>
                                        <div class=" col-lg-12 col-sm-12">
                                            <textarea class="form-control" name="posts_shortdesc_<?php echo $rsLang->language_code; ?>" id="posts_shortdesc_<?php echo $rsLang->language_code; ?>" rows="5"></textarea>
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

            <div class="col-md-5">
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">ATTRIBUTES</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body" style="padding-top: 20px;">
                        <div class="form-group">
                            <label class="col-md-12 left-padding">SORT</label>
                            <div class=" col-md-12 col-sm-12" style="padding: 0px;">
                                <input type="text" class="form-control" name="posts_sort" id="posts_sort">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Slider Image</span>
                            </div>
                            <div class="col-md-12" style="padding: 0px;">
                                <div class="input-group input-group-file">
                                    <input type="text" class="form-control" id="posts_images_fname" name="posts_images_fname">
                                    <span class="input-group-btn">
                                        <span class="btn btn-success btn-file">
                                            <i class="icon wb-upload" aria-hidden="true"></i>
                                            <input type="file" name="posts_images" id="posts_images" accept="image/*">
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <small>Image size : <?php echo GET_GENERAL('slider_width'); ?>px x <?php echo GET_GENERAL('slider_height'); ?>px</small>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Slider Link</span>
                            </div>
                            <div class="col-md-12" style="padding: 0px;">
                                <input placeholder="http://" class="form-control" type="text" name="posts_link" id="posts_link" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
                
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">PUBLISH</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-6 left-padding">
                                <span>Status</span>
                            </div>
                            <div class="col-md-6 right-padding">
                                <ul class="list-unstyled list-inline">
                                    <li class="margin-right-25 margin-bottom-25">
                                        <input type="checkbox" name="posts_status" class="js-switch-small" value="Y" data-plugin="switchery" data-size="small" checked />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Publish</button>
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
            </div>            
            <div class="col-md-8 panel">
                <div class="panel-footer text-right" style="margin-top: 13px; padding-right: 0px;">
                    <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Publish</button>
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
                    
                    posts_sort: {
                        validators: {
                            notEmpty: {
                                message: 'Sort is required'
                            }
                        }
                    },
                    
                    posts_images: {
                        validators: {
                            notEmpty: {
                                message: 'Image file is required'
                            }
                        }
                    },
                    
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
    
    $('#posts_images').change(function() {
        var filename = $('#posts_images').val();
        $('#posts_images_fname').val(filename);
    });
    
</script>