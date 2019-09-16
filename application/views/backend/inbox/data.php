<?php
            if ($this->uri->segment(4) == TRUE) {
                $NILAI                  = $this->uri->segment(4);
            } else {
                $NILAI                  = 0;
            }

            $LIMIT						= 10;

            $data['GET_INBOX']	        = $this->db->query("SELECT * FROM cd_message ORDER BY contact_logtime DESC LIMIT ".$NILAI.", ".$LIMIT."");
            
            $config['base_url'] 		= base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/pages');

            //Get Row data
            $cekRow	                    = $this->db->query("SELECT * FROM cd_message ORDER BY contact_logtime DESC");
            $config['total_rows'] 		= $cekRow->num_rows();
            $config['per_page'] 		= $LIMIT;
            $config['num_links'] 		= '4';
            $config['uri_segment'] 		= '4';

            $config['full_tag_open'] 	= '<ul class="pagination pagination-no-border">';
            $config['full_tag_close'] 	= '</ul>';
                    
            $config['cur_tag_open']     = '<li class="active"><a href="#">';
            $config['cur_tag_close']    = '</a></li>';
                    
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
                    
            $config['first_tag_open']   = '<li>';
            $config['first_tag_close']  = '</li>';
            $config['first_link'] 		= 'First';
                    
            $config['last_tag_open']    = '<li>';
            $config['last_tag_close']   = '</li>';
            $config['last_link'] 		= 'Last';
                    
            $config['prev_tag_open']    = '<li>';
            $config['prev_tag_close']   = '</li>';
            $config['prev_link'] 		= 'prev';
                    
            $config['next_tag_open']    = '<li>';
            $config['next_tag_close']   = '</li>';
            $config['next_link'] 		= 'next';


            $this->pagination->initialize($config);
            $data['pages'] 				= $this->pagination->create_links();
?>
<div class="page animsition">
    <div class="page-header">
        <h1 class="page-title"><?php echo $TITLE_PAGE; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('jpanel/cpanelx'); ?>">Home</a>
            </li>
            <li class="active">
                <?php echo $TITLE_PAGE; ?>
            </li>
        </ol>

    </div>


    <div class="page-content">
        <div class="row">
            <div class="panel">
                <div class="panel-body">
                    <h1 class="page-search-title"><i class="site-menu-icon wb-inbox" aria-hidden="true"></i> Inbox</h1>
                    
                    <ul class="list-group list-group-full list-group-dividered">
                        
                        <?php 
                            foreach($data['GET_INBOX']->result() as $rsInbox):
                        ?>
                        <li class="list-group-item">
                            <h4><a href="#"><?php echo $rsInbox->contact_name; ?></a></h4>
                            <a href="mailto:<?php echo $rsInbox->contact_email; ?>" target="_top"><?php echo $rsInbox->contact_email; ?></a><br />
                            <span class="search-result-link"><?php echo dateDiff(date('Y-m-d H:i:s'), $rsInbox->contact_logtime); ?></span>
                            <p><?php echo $rsInbox->contact_message; ?></p>
                            <p>
                                <span style="margin-right: 10px; cursor: pointer;" onclick="deleteInbox('<?php echo $rsInbox->contact_uid; ?>')"><a href="#"><i class="site-menu-icon wb-trash" style="margin-right: 5px;"></i>Delete </a></span>
                            </p>
                        </li>
                        <?php
                            endforeach;
                        ?>
                        
                    </ul>
                    <nav>
                        <?php echo $data['pages']; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function deleteInbox(LOCK_CODE) {
            bootbox.dialog({
                title: "<i class='icon fa-question-circle'></i> Confirm",
                message: 'Are you sure delete ?',
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
                                url : BASE_URL + 'jpanel/inbox/trash/',
                                type: 'POST',
                                data: {
                                    LOCK_CODE : LOCK_CODE
                                }, 
                                success: function (response) {
                                    //console.log(response);
                                    window.location = BASE_URL + 'jpanel/inbox'
                                }
                            });
                            
                        }
                    }
                    
                }
            });
    }
    
</script>