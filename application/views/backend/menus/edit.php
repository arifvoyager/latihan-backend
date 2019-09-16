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
    
    .cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
    * html .cf { zoom: 1; }
    *:first-child+html .cf { zoom: 1; }

    h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }

    a { color: #2996cc; }
    a:hover { text-decoration: none; }

    p { line-height: 1.5em; }
    .small { color: #666; font-size: 0.875em; }
    .large { font-size: 1.25em; }

    /**
     * Nestable
     */

    .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

    .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
    .dd-list .dd-list { padding-left: 30px; }
    .dd-collapsed .dd-list { display: none; }

    .dd-item,
    .dd-empty,
    .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

    .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:         linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
                border-radius: 3px;
        box-sizing: border-box; -moz-box-sizing: border-box;
    }
    .dd-handle:hover { color: #2ea8e5; background: #fff; }

    .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
    .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
    .dd-item > button[data-action="collapse"]:before { content: '-'; }

    .dd-placeholder,
    .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
    .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
        background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                          -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                             -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                                  linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
        background-size: 60px 60px;
        background-position: 0 0, 30px 30px;
    }

    .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
    .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
                box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
    }

    /**
     * Nestable Extras
     */

    .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

    #nestable-menu { padding: 0; margin: 20px 0; }

    #nestable-output,
    #nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

    #nestable2 .dd-handle {
        color: #fff;
        border: 1px solid #999;
        background: #bbb;
        background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
        background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
        background:         linear-gradient(top, #bbb 0%, #999 100%);
    }
    #nestable2 .dd-handle:hover { background: #bbb; }
    #nestable2 .dd-item > button:before { color: #fff; }

    @media only screen and (min-width: 700px) {

        .dd { float: left; width: 48%; }
        .dd + .dd { margin-left: 2%; }

    }

    .dd-hover > .dd-handle { background: #2ea8e5 !important; }

    /**
     * Nestable Draggable Handles
     */

    .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
        background: #fafafa;
        background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
        background:         linear-gradient(top, #fafafa 0%, #eee 100%);
        -webkit-border-radius: 3px;
                border-radius: 3px;
        box-sizing: border-box; -moz-box-sizing: border-box;
    }
    .dd3-content:hover { color: #2ea8e5; background: #fff; }

    .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

    .dd3-item > button { margin-left: 30px; }

    .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
        border: 1px solid #aaa;
        background: #ddd;
        background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
        background:         linear-gradient(top, #ddd 0%, #bbb 100%);
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
    .dd3-handle:hover { background: #ddd; }
</style>
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
    
    <?php $GET_GROUPMENU = $this->db->get_where("cd_taxonomy", array('taxonomy_lock_code' => $LOCK_CODE)); ?>
    <div class="page-content">
        <div class="row">
            
            <div class="col-md-4">
                <form action="<?php echo base_url('jpanel/menus/addtomenu/'.$LOCK_CODE); ?>" method="post" name="menu_pages" id="menu_pages">
                <!-- Example Panel With Heading -->
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">PAGES</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            
                            <input type="hidden" name="group_menu" id="group_menu" value="<?php echo $GET_GROUPMENU->row()->taxonomy_value; ?>">
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox" name="page_menu_home" id="page_menu_home" value="home" />
                                <label>Home</label>
                            </div>
                            
                            <?php 
                                $GET_PAGES = $this->db->get_where('cd_posts', array('posts_status' => 'Y', 'posts_type' => 'pages', 'posts_lang' => GET_DEFAULT_LANG()));
                                foreach($GET_PAGES->result() as $rsPages):
                            ?>
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox" name="page_menu[]" id="page_menu" value="<?php echo $rsPages->posts_lock_code; ?>"/>
                                <label><?php echo $rsPages->posts_title; ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>
                        </div>
                        
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Add To Menu</button>
                    </div>
                </div>
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">All Post</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="form-group">
                            
                            <input type="hidden" name="group_menu" id="group_menu" value="<?php echo $GET_GROUPMENU->row()->taxonomy_value; ?>">
                            
                            <?php 
                                $GET_POST = $this->db->get_where('cd_posts', array('posts_status' => 'Y', 'posts_type' => 'about', 'posts_lang' => GET_DEFAULT_LANG()));
                                foreach($GET_POST->result() as $rsPost):
                            ?>
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox" name="page_menu[]" id="page_menu" value="<?php echo $rsPost->posts_lock_code; ?>"/>
                                <label><?php echo $rsPost->posts_title; ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>
                        </div>
                        
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Add To Menu</button>
                    </div>
                </div>
                <!-- End Example Panel With Heading -->
                </form>
                
                <!-- Example Panel With Heading -->
                <form action="<?php echo base_url('jpanel/menus/addtomenulink/'.$LOCK_CODE); ?>" method="post" name="menu_link" id="menu_link">
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">CUSTOM LINK</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        
                        <input type="hidden" name="group_menu" id="group_menu" value="<?php echo $GET_GROUPMENU->row()->taxonomy_value; ?>">
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>URL</span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <input type="text" class="form-control" name="url_menu" id="url_menu" placeholder="http://">
                            </div>
                        </div>
                        
                        <?php
                            $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                            foreach($GET_LANG->result() as $rsLang):
                        ?>
                        <div class="clearfix">&nbsp;</div>
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <span>Link Text <?php echo $rsLang->language_flag; ?></span>
                            </div>
                            <div class="col-md-12 left-padding">
                                <input type="text" class="form-control" name="link_text_<?php echo $rsLang->language_code; ?>" id="link_text_<?php echo $rsLang->language_code; ?>">
                            </div>
                        </div>
                        <?php
                            endforeach;
                        ?>      
                        
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary"><i class="icon fa-check-square-o"></i> Add To Menu</button>
                    </div>
                </div>
                </form>
                <!-- End Example Panel With Heading -->
                
            </div>
            
            <div class="col-md-8">
                <!-- Example Panel With Heading -->
                <form action="<?php echo base_url('jpanel/menus/updatemenusort/'.$LOCK_CODE); ?>" method="post" name="menu_link" id="menu_link">
                <div class="panel panel-bordered panel-primary">
                    <div class="panel-heading">
                        
                        <h4 class="panel-title">MENU STRUCTURE</h4>
                        <div class="panel-actions">
                            <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-expanded="true" aria-hidden="true"></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-md-12 left-padding">
                                <h4><?php echo $GET_GROUPMENU->row()->taxonomy_value; ?></h4>
                                <span>Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</span>
                            </div>
                            
                            <div class="dd" id="nestable">
                                
                                <ol class="dd-list">
                                <?php
                                    $QPARENT = $this->db->query("SELECT * FROM cd_menu WHERE menu_parent = '0' AND menu_group = '".$GET_GROUPMENU->row()->taxonomy_value."' AND menu_lang = '".GET_DEFAULT_LANG()."' ORDER BY menu_sort ASC");
                                    foreach($QPARENT->result() as $rsParent):
                                        echo "<li class=\"dd-item\" data-id=\"".$rsParent->menu_lock_code."\">
                                                    <div class=\"dd-handle\">".$rsParent->menu_caption." <span class=\"pull-right dd-nodrag\"><a href=\"#\" onclick=\"delmenu('".$rsParent->menu_lock_code."')\"><i class=\"icon fa-trash-o\"></i></a> | <a href=\"".base_url('jpanel/menus/editmenus/'.$rsParent->menu_lock_code)."\">Edit</a></span></div>";
                
                                        $QCHILD = $this->db->query("SELECT * FROM cd_menu WHERE menu_parent = '".$rsParent->menu_lock_code."' AND menu_group = '".$GET_GROUPMENU->row()->taxonomy_value."' AND menu_lang = '".GET_DEFAULT_LANG()."' ORDER BY menu_sort ASC");
                                        if($QCHILD->num_rows() > 0) {
                                            echo '<ol class="dd-list">';
                                            foreach($QCHILD->result() as $rsMenu):
                                                echo "<li class=\"dd-item\" data-id=\"".$rsMenu->menu_lock_code."\"><div class=\"dd-handle\">".$rsMenu->menu_caption." <span class=\"pull-right dd-nodrag\"><a href=\"#\" onclick=\"delmenu('".$rsMenu->menu_lock_code."')\"><i class=\"icon fa-trash-o\"></i></a> | <a href=\"".base_url('jpanel/menus/editmenus/'.$rsMenu->menu_lock_code)."\">Edit</a></span></div></li>";
                                            
                                            endforeach;
                                            echo '</ol>';
                                        }

                                        echo '</li>';

                                    endforeach;
                                ?>
                                </ol>
                                
                            </div>
                            <textarea id="nestable-output" name="output-menu" style="display: none;"></textarea>
                            <input type="hidden" name="lock_code" id="lock_code" value="<?php echo $LOCK_CODE; ?>">
                        </div>
                        
                        
                        
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary" id="btn-save-menu-x"><i class="icon fa-check-square-o"></i> Save Menu</button>
                    </div>
                </div>
                </form>
                <!-- End Example Panel With Heading -->
            </div>
            
        </div>
    </div>
</div>

<script src="<?php echo base_url("assets/backend/js/components/panel.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/backend/vendor/formvalidation/framework/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/vendor/jquery.nestable.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1,
            maxDepth: 2
        })
        .on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        
        
        $('#menu_link')
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
                         $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                         foreach($GET_LANG->result() as $rsLang):
                    ?>
                    link_text_<?php echo $rsLang->language_code; ?>: {
                        validators: {
                            notEmpty: {
                                message: 'Link text <?php echo $rsLang->language_code; ?> is required'
                            }
                        }
                    },
                    <?php endforeach; ?>
                }
            });
        
    });
    
    
    function delmenu($LOCK_CODE) {
        var lock_code   = $('#lock_code').val();
        
        bootbox.dialog({
            message: "Are you sure delete data ?",
            title: "Confirm",
            buttons: {

                danger: {
                    label: "No",
                    className: "btn-danger",
                    callback: function () {
                        var pathname 	= window.location.href; 
                        window.location = pathname; 
                    }
                },

                success: {
                    label: "Yes",
                    className: "btn-success",
                    callback: function () {

                        $.ajax({
                            url : BASE_URL + 'jpanel/menus/trashMenuSelected/',
                            type: 'POST',
                            data: {
                                LOCK_CODE : $LOCK_CODE
                            }, 
                            success: function (response) {
                                console.log(response);
                                window.location = BASE_URL + 'jpanel/menus/editdata/' + lock_code
                            }
                        });
                    }
                }
            }
        });
    }
    
</script>