<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpanelx extends CI_Controller {
	
	function __construct() {
		parent::__construct();	
        date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index() {
        if ($this->session->userdata('sess_cpanelx') == TRUE) {
            
            $data['STR_PAGES']       = 'PAGE_DASHBOARD';
            $data['STR_MENU']        = 'Dashboard';
            $data['content']         = 'dashboard.php';
            $this->load->view('backend/index', $data);
            
        } else {
            $this->load->view('backend/FormLogin');
        }
    }
    
    public function auth() {
        if ($this->session->userdata('sess_cpanelx') == FALSE) {
            
            //CEK DATA LOGIN
            $CEK_LOGIN = $this->db->get_where('cd_admin_users', array('admin_users_username' => trim(strip_tags($this->input->post('USERNAME')))));
            if($CEK_LOGIN->num_rows() > 0) {
                
                //CEK PASSWORD
				$TEMP_PASSWD 	= trim(strip_tags($this->input->post('PASSWORD')));
				$ENCODE_PASSWD 	= $CEK_LOGIN->row()->admin_users_password;
				$DECODE_PASSWD 	= $this->encrypt->decode($ENCODE_PASSWD);
                $CHCEK_STATUS   = $CEK_LOGIN->row()->admin_users_status;
                
                if($TEMP_PASSWD == $DECODE_PASSWD) {
                    
                    if($CHCEK_STATUS == 'Y') {
                        
                        //SET SESSION
                        $this->session->set_userdata('sess_cpanelx', 'VALID');
                        $this->session->set_userdata('sess_cpanelx_uid', $CEK_LOGIN->row()->admin_users_uid);
                        $this->session->set_userdata('sess_cpanelx_aliasname', $CEK_LOGIN->row()->admin_users_aliasname);
                        $this->session->set_userdata('sess_cpanelx_regdate', $CEK_LOGIN->row()->admin_users_registerdate);
                        $this->session->set_userdata('sess_cpanelx_level', $CEK_LOGIN->row()->admin_users_level);
                        $this->session->set_userdata('sess_cpanelx_avatar', $CEK_LOGIN->row()->admin_users_avatar);

                        //UPDATE LAST LOGIN
                        $GET_DATETIME = getDateTime();
                        $this->db->where('admin_users_username', $CEK_LOGIN->row()->admin_users_username);
                        $this->db->update('cd_admin_users', array('admin_users_lastlogin' => $GET_DATETIME));
                        
                        echo "success";
                        
                    } else {
                        echo "disabled";   
                    }
                    
                } else {
                    echo "failed";
                }
                
            } else {
                echo "failed";
            }
            
        } else {
            $this->load->view('backend/index');
        }
    }
    
    public function resetpassword() {
        if ($this->session->userdata('sess_cpanelx') == FALSE) {
            $this->load->view('backend/ForgotPassword');
            
        } else {
            $this->load->view('backend/cpanelx');
        }
    }
    
    public function requestpaswd() {
        if ($this->session->userdata('sess_cpanelx') == FALSE) {
        
            $EMAIL          = trim(strip_tags($this->input->post('EMAIL')));  
            $CHECK_EMAIL    = $this->db->get_where('jawata_userlogin', array('admin_users_email' => $EMAIL));
            if($CHECK_EMAIL->num_rows() > 0) {
                //- GET PASSWD
                $PASSWD     = $CHECK_EMAIL->row()->admin_users_password;
                $UNAME      = $CHECK_EMAIL->row()->admin_users_username;

                $DECODE_PASSWD  = $this->encrypt->decode($PASSWD);

                //- SEND EMAIL ----------------------------------------------------------------------------------------
                $PARAMS['TABLE_NAME']   = 'jawata_email';
                $PARAMS['WHERE']        = array(
                    'email_flag'   => 'EMAIL_FORGOT_PASSWD_MEMBER'
                );
                $DRAFT_EMAIL    = $this->mod_getdata->getData($PARAMS);
                $SENDER         = $DRAFT_EMAIL->row()->email_sender;
                $EMAIL_CC       = $DRAFT_EMAIL->row()->email_to;
                $SUBJECT        = $DRAFT_EMAIL->row()->email_subject;
                $CONTENT        = $DRAFT_EMAIL->row()->email_message;

                $CONTENT        = str_replace('[username]', $UNAME, $CONTENT);
                $CONTENT        = str_replace('[passwd]', $DECODE_PASSWD, $CONTENT);

                $EMAIL_TO       = $EMAIL;

                //echo $CONTENT;
                //====================================================================================================
                sendEmail($SENDER, $EMAIL_TO, $EMAIL_CC, $SUBJECT, $CONTENT);
                //====================================================================================================
                
                echo "success";
                
            } else {
                echo "failed";   
                
            }

            
        } else {
            $this->load->view('backend/cpanelx');
        }
    }
    
	public function logout() {
        //UPDATE LAST LOGIN
        $GET_DATETIME = getDateTime();
        $this->db->where('admin_users_uid', $this->session->userdata('sess_cpanelx_uid'));
        $this->db->update('cd_admin_users', array('admin_users_lastlogout' => $GET_DATETIME));
        
		$this->session->sess_destroy();
		redirect(base_url('backend/cpanelx'));
	}
    
}