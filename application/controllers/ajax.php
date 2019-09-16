<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	function __construct() {
		parent::__construct();
    }
    
    //------------------------------------------------------------------------------------------------------------------------
    // CONSTRUKTOR
    //------------------------------------------------------------------------------------------------------------------------
    public function index() {
        $uri_page               = $this->uri->segment(2);
        $page_file              = 'page_'.str_replace('-', '_', $uri_page).'.php';
        
        $data['content']        = 'pages/'.$page_file;
        $this->load->view('index', $data);
    }
    
    public function setCurr() {
        SET_CURRENCY($this->input->post('curr'));
    }
    
    public function setLang() {
        SET_LANG($this->input->post('lang'));
        
        echo base_url();
    }
    
    public function getEventsDetail() {
        $lock_code      = $this->input->post('lock_code');
        $array_events   = array(
            'id'        => 'acara',
            'en'        => 'events'
        );
        $curr_lang      = GET_CURRENT_LANG();        
        
        $event_detail   = $this->db->get_where('cd_posts', array('posts_type' => 'events', 'posts_lang' => $curr_lang['code'], 'posts_lock_code' => $lock_code))->row();
        
        $result         = '';
        $result         .= '<label class="title">'.$event_detail->posts_title.'</label>';
        $result         .= '<img class="img-responsive" src="'.base_url('pubs/uploads/'.$event_detail->posts_images).'" />';
        $result         .= '<p>'.$event_detail->posts_shortdesc.'</p>';
        $result         .= '<label class="button btn-srad btn-p8 btn-bgorange" onclick="javascript:location.href=\''.base_url($array_events[$curr_lang['code']].'/d/'.$event_detail->posts_slug).'\'">'.GET_LABEL('BUTTON_SEE_DETAIL', $curr_lang['code']).'</label>';
        $result         .= '<i class="fa fa-times" onclick="javascript:closePopover();"></i>';

        echo $result;
    }
}