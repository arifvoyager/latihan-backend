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
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 200px;
    }
    
</style>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('cms/cpanelx'); ?>">Home</a></li>
            <li class="active">
                <a href="<?php echo base_url('cms/general'); ?>">General</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
        <form action="<?php echo base_url('cms/general/updated/'.$LOCK_CODE); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation" enctype="multipart/form-data">
            <div class="col-md-9 panel left-padding">
                
                <!-- Example Tabs Solid -->
                <div class="example-wrap">
                    <div class="nav-tabs-horizontal nav-tabs-inverse">
                        <?php
                        $iLoop = 1;
                        $GET_LANG = GET_LANG();
                        
                        if ($SELECTED->row()->general_multilanguage == 'Y') {
                            if($GET_LANG->num_rows() > 1){
                                ?>
                                    <ul class="nav nav-tabs" data-plugin="nav-tabs" role="tablist">
                                        <?php
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
                                <?php 
                            }
                        }
                        ?>
                        <div class="tab-content">
                            <?php
                                if ($SELECTED->row()->general_multilanguage == 'Y') {
                                    $iLoop = 1;

                                    $GET_LANG = GET_LANG();

                                    foreach($GET_LANG->result() as $rsLang):
                                        if($iLoop == 1) {
                                            $strActive = 'active';
                                        } else {
                                            $strActive = '';
                                        }

                                        //-GET SELECTED
                                        $GET_SELECTED = $this->db->get_where('cd_general', array('general_lock_code' => $LOCK_CODE, 'general_lang' => $rsLang->language_code))->row();

                                        if(count($GET_SELECTED) == 0) {
                                            $fields = $this->db->list_fields('cd_general');

                                            foreach ($fields as $field){
                                                $temp[$field] = '';
                                            } 
                                            $GET_SELECTED = (object)$temp;
                                        } 

                                        ?>
                                            <div class="tab-pane <?php echo $strActive; ?>" id="tab_<?php echo $rsLang->language_code; ?>" role="tabpanel" style="background-color: #FFF;">
                                                <div class="col-md-12" style="padding-top: 20px;">
                                                    <div class="form-group">
                                                        <label class="col-lg-12 col-sm-12 control-label text-left">General Title <?php if(GET_COMPANY('multilanguage') == 'Y') { echo $rsLang->language_flag; } ?></label>
                                                        <div class="col-lg-12 col-sm-12">
                                                            <input value="<?php echo $GET_SELECTED->general_name; ?>" type="text" class="form-control" name="general_name_<?php echo $rsLang->language_code; ?>" id="general_name_<?php echo $rsLang->language_code; ?>" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-lg-12 col-sm-12 control-label text-left">General Caption</label>
                                                        <div class="col-lg-12 col-sm-12">
                                                            <textarea class="form-control" name="general_caption_<?php echo $rsLang->language_code; ?>" id="general_caption_<?php echo $rsLang->language_code; ?>" rows="6"><?php echo $GET_SELECTED->general_caption; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <input value="<?php echo $GET_SELECTED->general_tags; ?>" type="hidden" class="form-control" name="general_tags_<?php echo $rsLang->language_code; ?>" id="general_tags_<?php echo $rsLang->language_code; ?>">
                                                    <input value="<?php echo $GET_SELECTED->general_multilanguage; ?>" type="hidden" class="form-control" name="general_multilanguage" id="general_multilanguage">
                                                </div>

                                            </div>
                                        <?php
                                        $iLoop++;
                                    endforeach;
                                } else {
                                    ?>
                                        <div class="tab-pane active" id="tab" role="tabpanel" style="background-color: #FFF;">
                                            <div class="col-md-12" style="padding-top: 20px;">
                                                <div class="form-group">
                                                    <label class="col-lg-12 col-sm-12 control-label text-left">General Title</label>
                                                    <div class="col-lg-12 col-sm-12">
                                                        <input value="<?php echo $SELECTED->row()->general_name; ?>" type="text" class="form-control" name="general_name" id="general_name" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-12 col-sm-12 control-label text-left">General Caption</label>
                                                    <div class="col-lg-12 col-sm-12">
                                                        <textarea class="form-control" name="general_caption" id="general_caption" rows="6"><?php echo $SELECTED->row()->general_caption; ?></textarea>
                                                    </div>
                                                </div>

                                                <input value="<?php echo $SELECTED->row()->general_tags; ?>" type="hidden" class="form-control" name="general_tags" id="general_tags">
                                                <input value="<?php echo $SELECTED->row()->general_multilanguage; ?>" type="hidden" class="form-control" name="general_multilanguage" id="general_multilanguage">
                                            </div>

                                        </div>
                                    <?php
                                }
                            ?>
                            
                        </div>
                        
                    </div>
                </div>
              <!-- End Example Tabs Solid -->
                
            </div>

            <div class="col-md-3">
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">PUBLISH</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Submit</button>
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
            </div>
        </form>
        </div>
    </div>
    
    
</div>

<script src="<?php echo base_url("assets/backend/js/components/panel.js"); ?>"></script>
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
                    
                    <?php
                         $GET_LANG = GET_LANG();
                         foreach($GET_LANG->result() as $rsLang):
                    ?>
                    general_caption_<?php echo $rsLang->language_code; ?>: {
                        validators: {
                            notEmpty: {
                                message: 'General Caption <?php echo $rsLang->language_code; ?> is required'
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