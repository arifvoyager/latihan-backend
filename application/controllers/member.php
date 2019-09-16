<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

    
    function __construct() {
	parent::__construct();
    }
    
    public function index() {
	$SESS_MEMBER = $this->session->userdata('sess_member_fi');
	
        if ($this->session->userdata('sess_member_fi') != false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();

            $data['member_detail']  = get_member_data($SESS_MEMBER['member_username']);
            
            $data['uri_page']       = $uri_page;
            $data['content']        = 'member/member.php';
            $data['content_member'] = 'member/member_profile.php';
            
            $this->load->view('index', $data);
        } else {
            redirect(base_url('member/login'));
        }
    }

    public function profile() {
	       $SESS_MEMBER = $this->session->userdata('sess_member_fi');
	    
        if ($this->session->userdata('sess_member_fi') != false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();

            $data['member_detail']  = get_member_data($SESS_MEMBER['member_username']);

            $data['uri_page']       = $uri_page;
            $data['content']        = 'member/member.php';
            $data['content_member'] = 'member/member_profile.php';
            $this->load->view('index', $data);
        } else {
            redirect(base_url('member/login'));
        }
    }
    
    public function edit_profile() {
	$SESS_MEMBER = $this->session->userdata('sess_member_fi');
	    
        if ($this->session->userdata('sess_member_fi') != false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();

            $data['member_detail']  = get_member_data($SESS_MEMBER['member_username']);

            $data['uri_page']       = $uri_page;
            $data['content']        = 'member/member.php';
            $data['content_member'] = 'member/member_edit.php';
            $this->load->view('index', $data);
        } else {
            redirect(base_url('member/login'));
        }
    }
    
    public function do_update() {
        if ($_FILES['member_logo']['error'] == 0) {
            $upload_image                  = upload_image('member_logo');
            $data['member_logo']           = $upload_image;
        }

        foreach ($this->input->post() as $key=>$val):
            if ($this->db->field_exists($key, 'cd_member')) {
                $data[$key]     = $val;
            }
        endforeach;

        //- UPDATE DATA
        $this->db->where('member_uid', $data['member_uid']);
        $this->db->update('cd_member', $data); 
        
        redirect(base_url('member/profile'));
    }
    
    public function change_password() {
	$SESS_MEMBER = $this->session->userdata('sess_member_fi');
	    
        if ($this->session->userdata('sess_member_fi') != false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();

            $data['member_detail']  = get_member_data($SESS_MEMBER['member_username']);

            $data['uri_page']       = $uri_page;
            $data['content']        = 'member/member.php';
            $data['content_member'] = 'member/member_change_password.php';
            $this->load->view('index', $data);
        } else {
            redirect(base_url('member/login'));
        }
    }
    
    public function dochange() {
	$SESS_MEMBER = $this->session->userdata('sess_member_fi');
	    
        $result                     = '';
        $old_password               = $this->input->post('member_old_password');
        $new_password               = $this->input->post('member_new_password');
        $check_member               = $this->db->get_where('cd_member', array('member_username' => $SESS_MEMBER['member_username']));
        
        if ($old_password == $this->encrypt->decode($check_member->row()->member_password)) {
            $update['member_password']  = $this->encrypt->encode($new_password);

            $this->db->where('member_username', $SESS_MEMBER['member_username']);
            $this->db->update('cd_member', $update);

            $this->session->unset_userdata('sess_member_fi');
            $result             = 'change_success';
        } else {
            $result             = 'not_match_password';
        }
        
        echo $result;
    }
    
    public function account() {
	$SESS_MEMBER = $this->session->userdata('sess_member_fi');
	    
        if ($this->session->userdata('sess_member_fi') != false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();

            $data['member_detail']  = get_member_data($SESS_MEMBER['member_email']);
            $data['content']        = 'member/member.php';
            $data['content_member'] = 'member/member_profile.php';
            $this->load->view('index', $data);
        } else {
            redirect(base_url('member/login'));
        }
    }
    
    public function login() {
        if ($this->session->userdata('sess_member_fi') == false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();

            $data['content']        = 'member/member_login.php';
            $this->load->view('index', $data);
        } else {
            redirect(base_url('member'));
        }
    }

    public function dologin() {
        $result                 = '';
        $member_username        = $this->input->post('member_username');
        $member_password        = $this->input->post('member_password');
        
        $check_exist_member             = $this->db->get_where('cd_member', array('member_username' => $member_username));
        
        if ($check_exist_member->num_rows() > 0) {
            if ($check_exist_member->row()->member_status == 'Active') {
                $password_decrypt   = $this->encrypt->decode($check_exist_member->row()->member_password);

                if ($password_decrypt == $member_password) {
                    $sess_member_fi['member_name']        = $check_exist_member->row()->member_name;
                    $sess_member_fi['member_username']   = $check_exist_member->row()->member_username;
                    
                    $this->session->set_userdata('sess_member_fi', $sess_member_fi);
                    
                    $result         = 'login_success';
                } else {
                    $result         = 'not_match_login';
                }
            } else {
                $result             = 'not_activated_member';
            }
        } else {
            $result             = 'not_exist_member';
        }
        
        echo $result;
    }
    
    public function register() {
        $data['LANG']           = GET_CURRENT_LANG();

        $data['content']        = 'member/member_register.php';
        $this->load->view('index', $data);
    }
    
    public function doregister() {
        $LANG                           = GET_CURRENT_LANG();
        $data['LANG']                   = $LANG;
        $result                         = '';

        $check_exist_member             = $this->db->get_where('cd_member', array('member_contact_email' => $this->input->post('member_contact_email')));
        
        if ($check_exist_member->num_rows() > 0) {
            $result                     = 'exist_member';
        } else {
            if ($_FILES['member_signature']['error'] == 0) {
                $upload_image                       = upload_image('member_signature');
                $data_member['member_signature']    = $upload_image;
            }

            foreach ($this->input->post() as $key=>$val):
                if ($this->db->field_exists($key, 'cd_member')) {
                    $data_member[$key]       = $val;
                }
            endforeach;

            $this->db->insert('cd_member', $data_member);

            $result                         = 'success';
        }
        
        $layout_email               = $this->db->get_where('cd_email', array('email_flag' => 'EMAIL_REGISTRATION_MEMBER', 'email_lang' => $LANG['code']))->row();

        $email_nickname             = $layout_email->email_nickname;
        $email_sender               = $layout_email->email_sender;
        $email_subject              = $layout_email->email_subject;
        $email_cc                   = $layout_email->email_cc;
        $email_bcc                  = $layout_email->email_bcc;

        $member_type                = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_cat', 'taxonomy_lock_code' => $data_member['member_type'], 'taxonomy_lang' => $LANG['code']))->row()->taxonomy_value;
        $member_due                 = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_due', 'taxonomy_lock_code' => $data_member['member_due'], 'taxonomy_lang' => $LANG['code']))->row();
        $member_signature           = '<img src="'.base_url('pubs/uploads/'.$data_member['member_signature']).'" style="height: 80px; widht: auto;"/>';
        $today                      = date('Y-m-d');
        $logo                       = '<img src="'.base_url('pubs/uploads/'.GET_COMPANY('company_logo')).'" style="height: 80px; width: auto; position: relative; left: 50%; transform: translateX(-50%);" />';
        $content                    = $layout_email->email_message;

        $content                    = str_replace('[tag_logo]', $logo, $content);
        $content                    = str_replace('[tag_name]', $data_member['member_name'], $content);
        $content                    = str_replace('[tag_director_name]', $data_member['member_directur_name'], $content);
        $content                    = str_replace('[tag_address]', $data_member['member_address'], $content);
        $content                    = str_replace('[tag_telephone]', $data_member['member_telephone'], $content);
        $content                    = str_replace('[tag_contact_name]', $data_member['member_contact_name'], $content);
        $content                    = str_replace('[tag_contact_position]', $data_member['member_contact_position'], $content);
        $content                    = str_replace('[tag_contact_email]', $data_member['member_contact_email'], $content);
        $content                    = str_replace('[tag_type]', $member_type, $content);
        $content                    = str_replace('[tag_due]', 'IDR '.number_format($member_due->taxonomy_value).' / '.$member_due->taxonomy_name, $content);
        $content                    = str_replace('[tag_date]', date("d F Y", strtotime($today)), $content);
        $content                    = str_replace('[tag_signature]', $member_signature, $content);

        //====================================================================================================
        sendEmail($email_nickname, $email_sender, $data_member['member_contact_email'], $email_subject, $content, $email_cc, $email_bcc);
        //====================================================================================================        

        $result                     = 'success';
        
        echo $result;
    }
    
    public function activation() {
        $LANG	                = GET_CURRENT_LANG();
        $data['LANG']		= $LANG;
        $member_email           = $this->input->get('email');
        $member_code            = $this->input->get('code');
        
        $check_exist_member     = $this->db->get_where('cd_member', array('member_email' => $member_email, 'member_activation_code' => $member_code));
        if ($check_exist_member->num_rows() > 0) {
            if ($check_exist_member->row()->member_status == 'N'){
                $data_member['member_status']   = 'Y';
                
                $data['title_result']   = GET_LABEL('LABEL_SUCCESS_ACTIVATION_MEMBER', $LANG['code']);
                $data['text_result']    = GET_LABEL('TEXT_SUCCESS_ACTIVATION_MEMBER', $LANG['code']);
                
                $this->db->where('member_email', $member_email);
                $this->db->where('member_activation_code', $member_code);
                $this->db->update('cd_member', $data_member);
            } else {
                $data['title_result']   = GET_LABEL('LABEL_EXIST_ACTIVATION_MEMBER', $LANG['code']);
                $data['text_result']    = GET_LABEL('TEXT_EXIST_ACTIVATION_MEMBER', $LANG['code']);
            }
        } else {
            $data['title_result']   = GET_LABEL('LABEL_NOT_EXIST_MEMBER', $LANG['code']);
            $data['text_result']    = GET_LABEL('TEXT_NOT_EXIST_MEMBER', $LANG['code']);
        }
        
        $data['content']        = 'member/member_activation.php';
        $this->load->view('index', $data);
    }
    
    public function dologout() {
        $this->session->unset_userdata('sess_member_fi');
        
        redirect(base_url());
    }
    
}