<style type="text/css">
    .title,
    .sub-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }
        .sub-title {
            font-size: 16px;
        }
</style>
<!-- Page -->
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a></li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>
        
    </div>
    <div class="page-content">
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row">
                    <div class="col-md-9" style="padding-left: 0px;">
                        <label class="title">Data Lembaga</label>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_NAME', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_name; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_DIRECTUR_NAME', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_directur_name; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_ADDRESS', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_address; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_TELEPHONE', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_telephone; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_NAME', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_contact_name; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_POSITION', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_contact_position; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_CONTACT_EMAIL', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $members->member_contact_email; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <?php
                                $member_type        = $this->db->get_where('cd_taxonomy', array('taxonomy_lock_code' => $members->member_type, 'taxonomy_lang' => GET_DEFAULT_LANG()))->row();
                            ?>
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_TYPE', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $member_type->taxonomy_value; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <?php
                                $member_due        = $this->db->get_where('cd_taxonomy', array('taxonomy_lock_code' => $members->member_due, 'taxonomy_lang' => GET_DEFAULT_LANG()))->row();
                            ?>
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_DUE', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px;">: <?php echo $member_due->taxonomy_name.' ( '.number_format($member_due->taxonomy_value).' )'; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label class="col-md-5" style="padding-left: 0px;"><?php echo GET_LABEL('LABEL_MEMBER_STATUS', GET_DEFAULT_LANG()); ?> </label>
                            <label class="col-md-7" style="padding-left: 0px; font-style: italic; font-weight: bold;">: <?php echo $members->member_status; ?></label>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <div class="col-md-3" style="padding-right: 0px;">
                        <?php
                            if ($members->member_logo == '') {
                                echo '<img src="'.base_url('pubs/uploads/images/NoLogo.jpg').'" style="width: 100%; height: auto;" />';
                            } else {
                                echo '<img src="'.base_url('pubs/uploads/'.$members->member_logo).'" style="width: 100%; height: auto;" />';
                            }
                        ?>
                        
                    </div>
                    <div class="col-md-12" style="padding: 0px;">
                        <label class="title">Profile</label>
                        <div class="col-md-6" style="padding-left: 0px;">
                            <label class="sub-title">Profile Indonesia</label>
                            <?php echo $members->member_profile_id; ?>
                        </div>
                        <div class="col-md-6" style="padding-right: 0px;">
                            <label class="sub-title">Profile English</label>
                            <?php echo $members->member_profile_id; ?>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <!-- 
                    <button type="button" class="btn btn-animate btn-animate-side btn-default btn-outline" onclick="javascript:window.open('')">
                        <span><i class="icon wb-print" aria-hidden="true"></i> Print</span>
                    </button>
                    -->
                    <button type="button" class="btn btn-default btn-outline" onclick="javascript:history.go(-1)">
                        <span><i class="icon wb-chevron-left" aria-hidden="true"></i> Back</span>
                    </button>
                </div>
            </div>
        </div>  
    </div>
</div>