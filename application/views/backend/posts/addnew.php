<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/ckeditor_4.5.3/toolbarconfigurator/lib/codemirror/neo.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/multi-select/multi-select.css"); ?>">
<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/select2/select2.css"); ?>">

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
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a></li>
            <li class="active">
                <a href="<?php echo base_url('jpanel/posts'); ?>">Posts</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
        <form action="<?php echo base_url('jpanel/posts/saved'); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation" enctype="multipart/form-data">
            <div class="col-md-9 panel left-padding">
                
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
                                <div class="col-md-12" style="padding-top: 20px;">
                                    <input type="hidden" name="posts_lang_<?php echo $rsLang->language_code; ?>" id="posts_lang_<?php echo $rsLang->language_code; ?>" value="<?php echo $rsLang->language_code; ?>" />
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">TITLE POSTS <?php if(GET_SETTING('multilanguage') == 'Y') { echo $rsLang->language_flag; } ?></label>
                                        <div class=" col-lg-12 col-sm-12">
                                            <input type="text" class="form-control" name="posts_title_<?php echo $rsLang->language_code; ?>" id="posts_title_<?php echo $rsLang->language_code; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">SHORT DESCRIPTION</label>
                                        <div class="col-lg-12 col-sm-12">
                                            <textarea class="form-control" name="posts_shortdesc_<?php echo $rsLang->language_code; ?>" id="posts_shortdesc_<?php echo $rsLang->language_code; ?>" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">CONTENT</label>
                                        <div class="col-lg-12 col-sm-12">
                                            <textarea class="form-control" name="posts_content_<?php echo $rsLang->language_code; ?>" id="posts_content_<?php echo $rsLang->language_code; ?>" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <h4>SEO Options</h4>
                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">META TITLE</label>
                                        <div class=" col-lg-12 col-sm-12">
                                            <input type="text" class="form-control" name="posts_meta_title_<?php echo $rsLang->language_code; ?>" id="posts_meta_title_<?php echo $rsLang->language_code; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-12 col-sm-12 control-label text-left">META DESCRIPTION</label>
                                        <div class="col-lg-12 col-sm-12">
                                            <textarea class="form-control" name="posts_meta_desc_<?php echo $rsLang->language_code; ?>" id="posts_meta_desc_<?php echo $rsLang->language_code; ?>" rows="3"></textarea>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" class="form-control" name="posts_slug_<?php echo $rsLang->language_code; ?>" id="posts_slug_<?php echo $rsLang->language_code; ?>">
                                    
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
                        
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Visibility</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" name="posts_visibility" id="posts_visibility" value="P" readonly checked />
                                    <label for="inputUnchecked">Public</label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Publish</button>
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
                
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">PAGE STYLE</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group" id="pages_category">
                            <div class="col-md-12 left-padding">
                                <span>Pages Type</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <select data-plugin="selectpicker" name="posts_category" id="posts_category">
                                    <option value="">-- Choose Type--</option>
                                    <?php 
                                    $GET_PAGE_CATEGORY = $this->db->get_where('jawata_taxonomy', array('taxonomy_flags' => 'pages_category', 'taxonomy_lang' => GET_DEFAULT_LANG()));
                                        foreach($GET_PAGE_CATEGORY->result() as $page_cateogry):
                                            echo "<option value=\"".$page_cateogry->taxonomy_slug."\">".$page_cateogry->taxonomy_caption."</option>";
                                        endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
                
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
                                <span>Image</span>
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
                            <small>Recommended Height Image Size : 280px</small>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Tags</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                
                                  <div class="select2-primary">
                                    <select class="form-control" multiple="multiple" data-plugin="select2" name="posts_tags[]" id="posts_tags">
                                    <?php
                                        $GET_CAT = $this->db->query("SELECT * FROM jawata_taxonomy WHERE taxonomy_flags = 'post_tags' AND taxonomy_lang = '".GET_DEFAULT_LANG()."' GROUP BY taxonomy_lock_code ORDER BY taxonomy_caption ASC");
                                        foreach($GET_CAT->result() as $rsCategory):
                                            echo "<option value=\"".$rsCategory->taxonomy_slug."\">".$rsCategory->taxonomy_caption."</option>";
                                        endforeach;
                                    ?>
                                    </select>
                                  </div>
                                    
                            </div>
                        </div>
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

                CKEDITOR.replace($('#posts_content_<?php echo $rsLang->language_code; ?>').attr('name'), {
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
    
    $('#posts_category_<?php echo GET_DEFAULT_LANG(); ?>').change(
        function() {
            var valcat = $('#posts_category_<?php echo GET_DEFAULT_LANG(); ?>').val();
            <?php
            foreach($GET_LANG->result() as $rsLang):
                if($rsLang->language_code != GET_DEFAULT_LANG() ) {
                    ?>
                        $('#posts_category_<?php echo $rsLang->language_code; ?> option[value="'+valcat+'"').prop('selected', 'selected');
                        $("#posts_category_<?php echo $rsLang->language_code; ?>").val(valcat).change();
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
    $('#posts_images').change(function() {
        var filename = $('#posts_images').val();
        $('#posts_images_fname').val(filename);
    });
    
</script>