<style type="text/css">
    dt {
        text-align: left !important;   
    }
</style>
<div class="page">
    <div class="page-header padding-0">
        <div class="widget widget-article type-flex">
            <div class="widget-header cover overlay">
                <img class="cover-image height-300" src="<?php echo base_url("assets/backend/example-images/dashboard-header.jpg"); ?>" alt="">
                <div class="overlay-panel text-center vertical-align">
                    <div class="widget-metas vertical-align-middle blue-grey-800">
                        <div class="widget-title font-size-50 margin-bottom-35 blue-grey-800"><?php echo GET_COMPANY('company_name'); ?></div>
                        <ul class="list-inline font-size-14">
                            <li>
                                <i class="icon wb-map margin-right-5" aria-hidden="true"></i>DKI Jakarta, Indonesia
                            </li>
                        </ul>
                        <div style="padding: 0 20%;"><?php echo GET_COMPANY('company_about'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xlg-3 col-lg-4 col-md-12">
                <!-- Panel Web Designer -->
                <div class="widget widget-shadow">
                    <div class="widget-content widget-radius text-center bg-white padding-40">
                        <div class="avatar avatar-100 margin-bottom-20">
                            <img src="<?php echo base_url("pubs/uploads/".$GET_PROFILE->row()->admin_users_avatar); ?>" alt="">
                        </div>
                        <p class="font-size-20 blue-grey-700"><?php echo $GET_PROFILE->row()->admin_users_aliasname; ?></p>
                        <p class="blue-grey-400 margin-bottom-20"><?php echo $this->session->userdata('sess_cpanelx_level'); ?></p>
                        
                        <button onclick="javascript:location.href='<?php echo base_url('jpanel/user/editdata/'.$this->session->userdata('sess_cpanelx_uid')); ?>'" type="button" class="btn btn-primary padding-horizontal-40">Profile</button>
                    </div>
                </div>
                <!-- End Panel Web Designer -->
            </div>

            <div class="col-xlg-6 col-lg-8 col-md-12">
                
                <div class="panel" >
                    <div class="panel-heading">
                        <div class="panel-actions">
                            <button onclick="javascript:location.href='<?php echo base_url('jpanel/setting'); ?>'" type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit">
                              <i class="icon wb-pencil" aria-hidden="true"></i>
                            </button>
                        </div>
                        <h3 class="panel-title">Company Info</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-xs-6" style="padding: 0px;">
                            <dl class="dl-horizontal">
                                    <dt>Name</dt>
                                    <dd><?php echo GET_COMPANY('company_name'); ?></dd>
                                    
                                    <dt>Phone</dt>
                                    <dd><?php echo GET_COMPANY('company_phone'); ?></dd>
                                    
                                    <dt>Fax</dt>
                                    <dd><?php echo GET_COMPANY('company_fax'); ?></dd>
                                    
                                    <dt>Address</dt>
                                    <dd><?php echo GET_COMPANY('company_address'); ?></dd>
                                    
                                    <dt>Email</dt>
                                    <dd><?php echo GET_COMPANY('company_email'); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>