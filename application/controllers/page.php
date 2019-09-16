<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	
	function __construct() {
		parent::__construct();
    }
    
    //------------------------------------------------------------------------------------------------------------------------
    // CONSTRUKTOR
    //------------------------------------------------------------------------------------------------------------------------
    public function index() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_page               = $this->uri->segment(1);
        $pages                  = $this->db->get_where('cd_posts', array('posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_page))->row();
        var_dump($pages->posts_file);
        
        $page_file              = 'page_'.str_replace('-', '_', $uri_page).'.php';
        
        $data['content']        = 'page/'.$pages->posts_file;
        $this->load->view('index', $data);
    }
    
    public function p() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_page               = $this->uri->segment(2);
        
        var_dump($uri_page);
    }
    
    public function statis() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri                    = $this->uri->segment(2);

        $pages                  = $this->db->get_where('cd_posts', array('posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri))->row();
        $cate_pages             = '';
        
        if ($pages->posts_type == 'sdg') {
            $cate_pages                 = 'Philanthropy for SDG';
            $data['title_pages']        = $cate_pages;
            $data['subtitle_pages']     = $pages->posts_title;
        } else if ($pages->posts_type == 'pages') {
            $data['title_pages']        = $pages->posts_title;
            $data['subtitle_pages']     = $pages->posts_subtitle;
        }
        
        $data['pages']          = $pages;
        $data['content']        = 'page/statis.php';
        $this->load->view('index', $data);
    }
    
    public function about() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        $uri                    = $this->uri->segment(2);
        
        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();
        
        if ($uri != false) {
            $get_about_detail       = $this->db->get_where('cd_posts', array('posts_type' => 'about', 'posts_slug' => $uri));
            $data['about']          = $get_about_detail->row();
            $data['content']        = 'page/about-item.php';
        } else {
            $get_about              = $this->db->get_where('cd_posts', array('posts_type' => 'about', 'posts_status' => 'Y', 'posts_lang' => GET_CURRENT_LANG()['code']));
            $data['get_about']      = $get_about;
            $data['content']        = 'page/about.php';
        }
        $this->load->view('index', $data);
    }
    
    public function contact() {
        $data['LANG']           = GET_CURRENT_LANG();
        $this->load->library('googlemaps');
        $data['LANG']               = GET_CURRENT_LANG();

        $config['center']           = GET_COMPANY('company_latitude').', '.GET_COMPANY('company_longitude');
        $config['map_width']        = '100%';
        $config['map_height']       = '245px';
        $config['map_name']         = 'map_one';
        $config['map_div_id']       = 'map_canvas_one';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position']         = GET_COMPANY('company_latitude').', '.GET_COMPANY('company_longitude');
        //$marker['position'] = '-6.166230303550424, 106.78686797618866';
        $this->googlemaps->add_marker($marker);
        $data['map']                = $this->googlemaps->create_map();

        $data['content']        = 'page/contact.php';
        $this->load->view('index', $data);
    }

    public function news() {
        var_dump('meong');
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        $uri                    = $this->uri->segment(2);

        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();        
        $get_news               = $this->db->get_where('cd_posts', array('posts_type' => 'news', 'posts_lang' => $data['LANG']['code']));
        
        if ($uri == false) {
            $data['content']        = 'page/news_list.php';
            $data['get_news']       = $get_news;
        } elseif ($uri == 'detail') {
            $news                   = $this->db->get_where('cd_posts', array('posts_type' => 'news', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $this->uri->segment(3)))->row();
            $data['news']           = $news;
            
            $count_news             = $news->posts_reads + 1;
            
            $this->db->where('posts_slug', $this->uri->segment(3));
            $this->db->update('cd_posts', array('posts_reads' => $count_news));
            
            $data['content']        = 'page/news_detail.php';
        } else {
            $data['content']        = 'page/news_list.php';
            $data['get_news']       = $get_news;
        }
        $this->load->view('index', $data);
    }

    public function events() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        $uri                    = $this->uri->segment(2);
        
        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();
        
        if ($uri == false) {
            $get_events             = $this->db->get_where('cd_posts', array('posts_type' => 'events', 'posts_lang' => $data['LANG']['code'], 'posts_status' => 'Y'), 'posts_date', 'ASC');

            $data['content']        = 'page/events_list.php';
            $data['get_events']     = $get_events;
        } else {
            $events                 = $this->db->get_where('cd_posts', array('posts_type' => 'events', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $this->uri->segment(2)))->row();
            
            $data['content']        = 'page/events_detail.php';
            $data['events']         = $events;
        }
        
        $this->load->view('index', $data);
    }
    
    public function partners() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        
        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();
        
        $get_mitra_category     = $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'mitra_cat', 'taxonomy_lang' => $data['LANG']['code']));

        $data['content']        = 'page/mitra_list.php';

        $this->load->view('index', $data);
    }

    public function organisasi() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        $uri_slug               = $this->uri->segment(2);
        
        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();

        if ($uri_slug == '') {
            $data['organisasi_cate']= $this->db->get_where('cd_taxonomy', array('taxonomy_flags' => 'members_cat', 'taxonomy_lang' => $data['LANG']['code']));
            $data['content']        = 'page/organisasi_list.php';
        } else {
            $data['organisasi']     = $this->db->get_where('cd_member', array('member_slug' => $uri_slug))->row();
            $data['content']        = 'page/organisasi_detail.php';
        }

        $this->load->view('index', $data);
    }
    
    public function gallery() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        
        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();

        $data['gallery_cate']   = $this->db->query('SELECT * FROM cd_taxonomy WHERE taxonomy_flags = "GALLERY_CATEGORY" AND taxonomy_lang = "'.$data['LANG']['code'].'" GROUP BY taxonomy_value');

        $data['uri_pages']      = $uri_pages;
        $data['content']        = 'page/gallery_list.php';

        $this->load->view('index', $data);
    }
    
    public function download() {
        $data['LANG']           = GET_CURRENT_LANG();
        $uri_pages              = $this->uri->segment(1);
        
        $data['pages']          = $this->db->get_where('cd_posts', array('posts_type' => 'pages', 'posts_lang' => $data['LANG']['code'], 'posts_slug' => $uri_pages))->row();
        
        $data['uri_pages']      = $uri_pages;
        $data['content']        = 'page/download.php';

        $this->load->view('index', $data);
    }
}