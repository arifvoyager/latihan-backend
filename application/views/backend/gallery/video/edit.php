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
        width: 100%;
    }
    
</style>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?> Category Gallery Video</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a></li>
            <li class="active">
                <a href="<?php echo base_url('jpanel/gallery/data/video'); ?>">Gallery</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
        <form action="<?php echo base_url('jpanel/gallery/updated/video/'.$LOCK_CODE); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation" enctype="multipart/form-data">
            <div class="col-md-9 panel left-padding">
                
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
                                $GET_SELECTED = $this->db->get_where('dp_posts', array('posts_lock_code' => $LOCK_CODE, 'posts_lang' => $rsLang->language_code))->row();
        
                                if(count($GET_SELECTED) == 0) {
                                    $fields = $this->db->list_fields('dp_posts');

                                    foreach ($fields as $field){
                                        $temp[$field] = '';
                                    } 
                                    $GET_SELECTED = (object)$temp;
                                } 
                            ?>
                            <div class="tab-pane <?php echo $strActive; ?>" id="tab_<?php echo $rsLang->language_code; ?>" role="tabpanel" style="background-color: #FFF;">
                                <div class="col-md-12" style="padding-top: 20px;">
                                    <input type="hidden" name="posts_lang_<?php echo $rsLang->language_code; ?>" id="posts_lang_<?php echo $rsLang->language_code; ?>" value="<?php echo $rsLang->language_code; ?>" />
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">GALLERY CATEGORY <?php if(GET_SETTING('multilanguage') == 'Y') { echo $rsLang->language_flag; } ?></label>
                                        <div class=" col-lg-12 col-sm-12">
                                            <select data-plugin="selectpicker" name="posts_tags_<?php echo $rsLang->language_code; ?>" id="posts_tags_<?php echo $rsLang->language_code; ?>">
                                                <option value="">-- Choose Type--</option>
                                                <?php   
                                                    $get_gallery_category = $this->db->get_where('dp_taxonomy', array('taxonomy_flags' => 'GALLERY_CATEGORY', 'taxonomy_value' => 'video', 'taxonomy_lang' => $rsLang->language_code));
                                                    
                                                    foreach ($get_gallery_category->result() as $gallery_category) : 
                                                        if($GET_SELECTED->posts_tags == $gallery_category->taxonomy_lock_code) {
                                                            $selected   = 'selected="selected"';
                                                        } else {
                                                            $selected   = '';
                                                        }
                                                        echo '<option value="'.$gallery_category->taxonomy_lock_code .'" '.$selected.'>'.$gallery_category->taxonomy_name.'</option>';
                                                    endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">GALLERY NAME</label>
                                        <div class="col-lg-12 col-sm-12">
                                            <input value="<?php echo $GET_SELECTED->posts_title; ?>" type="text" class="form-control" name="posts_title_<?php echo $rsLang->language_code; ?>" id="posts_title_<?php echo $rsLang->language_code; ?>" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="posts_lang_<?php echo $rsLang->language_code; ?>" id="posts_lang_<?php echo $rsLang->language_code; ?>" value="<?php echo $rsLang->language_code; ?>" />
                                    <input type="hidden" name="posts_slug_<?php echo $rsLang->language_code; ?>" id="posts_slug_<?php echo $rsLang->language_code; ?>" />
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

            <div class="col-md-3">
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Publish</button>
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
                
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

<script src="<?php echo base_url("assets/ckeditor_4.5.3/ckeditor.js"); ?>"></script>

<script type="text/javascript">
    $.components.register("select2", {
        mode: "default",
        defaults: {
            width: "style"
        }
    });
    <?php
         $GET_LANG = GET_LANG();
         foreach($GET_LANG->result() as $rsLang):
            ?>
                //- SLUG
                $( "#posts_title_<?php echo $rsLang->language_code; ?>" ).keyup(function() {
                    TEXT_DESC = $("#posts_title_<?php echo $rsLang->language_code; ?>").val();
                    TEXT_DESC = TEXT_DESC.replace (/[^a-z0-9]+|\s+/gmi, "-"); 
                    TEXT_DESC = TEXT_DESC.toLowerCase();

                    $("#posts_slug_<?php echo $rsLang->language_code; ?>").val(TEXT_DESC);
                });
            <?php
        endforeach; 
    ?>
    
    $('#posts_tags_<?php echo GET_DEFAULT_LANG(); ?>').change(
        function() {
            var valcat = $('#posts_tags_<?php echo GET_DEFAULT_LANG(); ?>').val();
            <?php
            foreach($GET_LANG->result() as $rsLang):
                if($rsLang->language_code != GET_DEFAULT_LANG() ) {
                    ?>
                        $('#posts_tags_<?php echo $rsLang->language_code; ?> option[value="'+valcat+'"').prop('selected', 'selected');
                        $("#posts_tags_<?php echo $rsLang->language_code; ?>").val(valcat).change();
                    <?php
                }
            endforeach; 
            ?>
        }
    );

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
                         $GET_LANG = $this->db->query("SELECT * FROM dp_language WHERE language_status = 'Y' ORDER BY language_default DESC");
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