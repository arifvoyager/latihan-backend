<link rel="stylesheet" href="<?php echo base_url("assets/backend/vendor/formvalidation/formValidation.css"); ?>">

<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('cms/cpanelx'); ?>">Home</a></li>
            <li><a href="#">Apperance</a></li>
            <li><a href="<?php echo base_url('cms/menus'); ?>">Menus</a></li>
            
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    
    
    <div class="page-content">
        <div class="row">
            <form action="<?php echo base_url('cms/menus/updatelistmenu/'.$LOCK_CODE); ?>" class="form-horizontal" method="post" name="frmaddnew" id="frmvalidation">
                <div class="col-md-6 panel">

                    <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                            
                            <?php 
                                $GET_DATA = $this->db->get_where('cd_menu', array('menu_lock_code' => $LOCK_CODE)); 
                                if($GET_DATA->row()->menu_type == 'U') {
                            ?>
                            <label class="col-lg-12 col-sm-12 control-label text-left">URL</label>
                            <div class=" col-lg-12 col-sm-12">
                                <input value="<?php echo $GET_DATA->row()->menu_link; ?>" maxlength="200" type="text" class="form-control" name="url_menu" id="url_menu" placeholder="http://">
                            </div>
                            <?php } ?>
                            
                            <?php
                                $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                                foreach($GET_LANG->result() as $rsLang):

                                $GET_SELECTED = $this->db->get_where('cd_menu', array('menu_lang' => $rsLang->language_code, 'menu_lock_code' => $LOCK_CODE));
                            ?>
                            <label class="col-lg-12 col-sm-12 control-label text-left">Link Text <?php echo $rsLang->language_flag; ?></label>
                            <div class=" col-lg-12 col-sm-12">
                                <input value="<?php echo $GET_SELECTED->row()->menu_caption; ?>" maxlength="50" type="text" class="form-control" name="link_text_<?php echo $rsLang->language_code; ?>" id="link_text_<?php echo $rsLang->language_code; ?>">
                            </div>
                            <?php
                                endforeach;
                            ?> 
                            
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
                    
                    <?php
                        $GET_LANG = $this->db->query("SELECT * FROM cd_language WHERE language_status = 'Y' ORDER BY language_default DESC");
                        foreach($GET_LANG->result() as $rsLang):
                    ?>
                    link_text_<?php echo $rsLang->language_code; ?>: {
                        validators: {
                            notEmpty: {
                                message: 'Link Text is required'
                            }
                        }
                    },
                    <?php
                        endforeach;
                    ?>
                }
            });
    });
    
</script>