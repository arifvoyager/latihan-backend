<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
	
	function __construct() {
		parent::__construct();
    }
    
    //------------------------------------------------------------------------------------------------------------------------
    // CONSTRUKTOR
    //------------------------------------------------------------------------------------------------------------------------
    public function index() {
        $LANG                       = GET_CURRENT_LANG();
        $category_product           = $this->db->get_where('dp_product_category', array('category_level' => '1', 'category_lang' => $LANG['code']));
        
        $data['content']            = 'product/product_category.php';
        $data['category_product']   = $category_product;
        $data['LANG']               = $LANG;
        $this->load->view('index', $data);
    }

    public function plist() {
        $LANG                       = GET_CURRENT_LANG();
        $cate_lock_code             = $this->uri->segment(3);
        $category_product           = $this->db->get_where('dp_product_category', array('category_level' => '1', 'category_lang' => $LANG['code']));
        $category_level             = $this->db->get_where('dp_product_category', array('category_lock_code' => $cate_lock_code, 'category_lang' => $LANG['code']))->row();
        
        if ($category_level->category_level == 1) {
            $this->session->unset_userdata('sess_category_level_2');
            $this->session->unset_userdata('sess_category_level_3');
            $this->session->unset_userdata('sess_category_level_4');
        } elseif ($category_level->category_level == 2) {
            $this->session->unset_userdata('sess_category_level_3');
            $this->session->unset_userdata('sess_category_level_4');
        } elseif ($category_level->category_level == 3) {
            $this->session->unset_userdata('sess_category_level_4');
        }
        $this->session->set_userdata('sess_category_level_'.$category_level->category_level, $category_level->category_lock_code);
        
        $get_product                = get_product_by_category($cate_lock_code);
        
        $data['content']            = 'product/product_list.php';
        $data['category_product']   = $category_product;
        $data['get_product']        = $get_product;
        $data['LANG']               = $LANG;
        $this->load->view('index', $data);
    }

    public function detail() {
        $data['LANG']               = GET_CURRENT_LANG();
        $pslug                      = $this->uri->segment(3);
        
        $product                    = get_product_detail_by_slug($pslug);
        
        $data['content']            = 'product/product_detail.php';
        $data['product']            = $product;
        $this->load->view('index', $data);
    }
    
}