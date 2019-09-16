<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MEMBERS';
            $data['STR_MENU']        = 'members';
            $data['TITLE_PAGE']      = 'Mitra';
            $data['content']         = 'members/data.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function getData() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $GET_LANG = $this->db->query("SELECT *, (SELECT taxonomy_value FROM cd_taxonomy B WHERE B.taxonomy_lock_code = A.member_type AND taxonomy_lang = '".GET_DEFAULT_LANG()."') as type_of_member FROM cd_member A WHERE member_super = 'N' ORDER BY member_name ASC");
            $strArray = array();
            
			foreach($GET_LANG->result() as $key=>$strObj) {
			    if($strObj->member_password) {
                    $strObj->member_password = $this->encrypt->decode($strObj->member_password);
                }
                
				$strArray[] = $strObj;
			}
				
			echo json_encode($strArray);
            
        } else {
            echo "Error load data";       
        }
    }
    
    public function view($UID) {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MEMBERS';
            $data['STR_MENU']        = 'members';
            $data['TITLE_PAGE']      = 'View Members';
            $data['content']         = 'members/view.php';
            $data['members']         = $this->db->get_where('cd_member', array('member_uid' => $UID))->row();
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
	
	public function addnew() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_MEMBERS_ADDNEW';
            $data['STR_MENU']        = 'members';
            $data['TITLE_PAGE']      = 'Add New';
            $data['content']         = 'members/addnew.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function approve() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $LANG                       = GET_CURRENT_LANG();
            $UID = trim(strip_tags($this->input->post('UID')));

            $member                     = $this->db->get_where('cd_member', array('member_uid' => $UID))->row();
            
            $layout_email               = $this->db->get_where('cd_email', array('email_flag' => 'EMAIL_APPROVED_MEMBER', 'email_lang' => $LANG['code']))->row();
            
            $email_nickname             = $layout_email->email_nickname;
            $email_sender               = $layout_email->email_sender;
            $email_subject              = $layout_email->email_subject;
            $email_cc                   = $layout_email->email_cc;
            $email_bcc                  = $layout_email->email_bcc;

            $logo                       = '<img src="'.base_url('pubs/uploads/'.GET_COMPANY('company_logo')).'" style="height: 80px; width: auto; position: relative; left: 50%; transform: translateX(-50%);" />';

            $content                    = $layout_email->email_message;

            $content                    = str_replace('[tag_logo]', $logo, $content);

            //====================================================================================================
            sendEmail($email_nickname, $email_sender, $member->member_contact_email, $email_subject, $content, $email_cc, $email_bcc);
            //====================================================================================================        
            
            $this->db->where('member_uid', $UID);
            $this->db->update('cd_member', array('member_status' => 'Approved')); 
            
            echo "success";
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function active() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            $LANG                       = GET_CURRENT_LANG();
            $UID = trim(strip_tags($this->input->post('UID')));

            $member                     = $this->db->get_where('cd_member', array('member_uid' => $UID))->row();
            
            $username                   = '';
            $generate_number            = rand(100, 999);
            foreach (explode(' ', $member->member_name) as $val) :
                $username               = $username.''.substr($val, 0, 3);
            endforeach;
            
            $username                   = $username.$generate_number;
            $password                   = getRandom(10, 10);
            $password_encode            = $this->encrypt->encode($password);        
            
            $layout_email               = $this->db->get_where('cd_email', array('email_flag' => 'EMAIL_ACTIVED_MEMBER', 'email_lang' => $LANG['code']))->row();
            
            $email_nickname             = $layout_email->email_nickname;
            $email_sender               = $layout_email->email_sender;
            $email_subject              = $layout_email->email_subject;
            $email_cc                   = $layout_email->email_cc;
            $email_bcc                  = $layout_email->email_bcc;

            $logo                       = '<img src="'.base_url('pubs/uploads/'.GET_COMPANY('company_logo')).'" style="height: 80px; width: auto; position: relative; left: 50%; transform: translateX(-50%);" />';

            $content                    = $layout_email->email_message;

            $content                    = str_replace('[tag_logo]', $logo, $content);
            $content                    = str_replace('[tag_username]', $username, $content);
            $content                    = str_replace('[tag_password]', $password, $content);

            //====================================================================================================
            sendEmail($email_nickname, $email_sender, $member->member_contact_email, $email_subject, $content, $email_cc, $email_bcc);
            //====================================================================================================        
            
            $this->db->where('member_uid', $UID);
            $this->db->update('cd_member', array('member_status' => 'Active', 'member_username' => $username, 'member_password' => $password_encode)); 
            
            echo "success";
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function deactive() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $UID = trim(strip_tags($this->input->post('UID')));
            $this->db->where('member_uid', $UID);
            $this->db->update('cd_member', array('member_status' => 'Deactived')); 
            
            echo "success";
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
}