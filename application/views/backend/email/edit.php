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
                <a href="<?php echo base_url('cms/email'); ?>">Email</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
        <form action="<?php echo base_url('cms/email/updated/'.$LOCK_CODE); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation" enctype="multipart/form-data">
            <div class="col-md-8 panel left-padding">
                
                <!-- Example Tabs Solid -->
                <div class="example-wrap">
                    <div class="nav-tabs-horizontal nav-tabs-inverse">
                        <?php
                        $iLoop = 1;
                        $GET_LANG = GET_LANG();
                        
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
                                
                                //-GET SELECTED
                                $GET_SELECTED = $this->db->get_where('cd_email', array('email_lock_code' => $LOCK_CODE, 'email_lang' => $rsLang->language_code))->row();
        
                                if(count($GET_SELECTED) == 0) {
                                    $fields = $this->db->list_fields('cd_email');

                                    foreach ($fields as $field){
                                        $temp[$field] = '';
                                    } 
                                    $GET_SELECTED = (object)$temp;
                                } 
                            ?>
                            <div class="tab-pane <?php echo $strActive; ?>" id="tab_<?php echo $rsLang->language_code; ?>" role="tabpanel" style="background-color: #FFF;">
                                <div class="col-md-12" style="padding-top: 20px;">
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">Subject Email <?php if(GET_COMPANY('multilanguage') == 'Y') { echo $rsLang->language_flag; } ?></label>
                                        <div class="col-lg-12 col-sm-12">
                                            <input value="<?php echo $GET_SELECTED->email_subject; ?>" type="text" class="form-control" name="email_subject_<?php echo $rsLang->language_code; ?>" id="email_subject_<?php echo $rsLang->language_code; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">News Content</label>
                                        <div class="col-lg-12 col-sm-12">
                                            <textarea class="form-control" name="email_message_<?php echo $rsLang->language_code; ?>" id="email_message_<?php echo $rsLang->language_code; ?>" rows="3"><?php echo $GET_SELECTED->email_message; ?></textarea>
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

            <div class="col-md-4">
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">ATTRIBUTES</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Nickname</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <input type="text" class="form-control" name="email_nickname" id="email_nickname" value="<?php echo $SELECTED->row()->email_nickname; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Email Sender Address</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <input type="text" class="form-control" name="email_sender" id="email_sender" value="<?php echo $SELECTED->row()->email_sender; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Email CC Address</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <input type="text" class="form-control" name="email_cc" id="email_cc" value="<?php echo $SELECTED->row()->email_cc; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Email BCC Address</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <input type="text" class="form-control" name="email_bcc" id="email_bcc" value="<?php echo $SELECTED->row()->email_bcc; ?>">
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
                                        <input type="checkbox" name="email_status" class="js-switch-small" value="Y" data-plugin="switchery" data-size="small" <?php if($SELECTED->row()->email_status == 'Y') { echo "checked"; } ?> />
                                    </li>
                                </ul>
                            </div>
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

<script src="<?php echo base_url("assets/ckeditor_4.5.3/ckeditor.js"); ?>"></script>

<script type="text/javascript">
    <?php
        $GET_LANG = GET_LANG();
        foreach($GET_LANG->result() as $rsLang):
            ?>
                //- TEXTEDITOR
                CKEDITOR.replace($('#email_message_<?php echo $rsLang->language_code; ?>').attr('name'), {
                    height: 400,
                    filebrowserBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=files',
                    filebrowserUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=files',
                    filebrowserImageBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=images',
                    filebrowserFlashBrowseUrl: BASE_URL + 'assets/kcfinder/browse.php?opener=ckeditor&type=flash',
                    filebrowserImageUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=images',
                    filebrowserFlashUploadUrl: BASE_URL + 'assets/kcfinder/upload.php?opener=ckeditor&type=flash',
                    customConfig: BASE_URL + '/assets/ckeditor_4.5.3/config.js'
                });
            <?php 
        endforeach; 
    ?>

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
                    posts_title_<?php echo $rsLang->language_code; ?>: {
                        validators: {
                            notEmpty: {
                                message: 'Post title <?php echo $rsLang->language_code; ?> is required'
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