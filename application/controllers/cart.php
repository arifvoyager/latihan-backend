<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {
	
	function __construct() {
		parent::__construct();
    }
    
    //------------------------------------------------------------------------------------------------------------------------
    // CONSTRUKTOR
    //------------------------------------------------------------------------------------------------------------------------
    public function index() {
        if ($this->session->userdata('session_cart_rba') != false) {
            $uri_page               = $this->uri->segment(2);
            $data['LANG']           = GET_CURRENT_LANG();
            $session_cart_rba       = $this->session->userdata('session_cart_rba');
            $get_cart               = $this->db->get_where('dp_temp_cart', array('temp_cart_session_cart' => $session_cart_rba));
            $get_cart_detail        = $this->db->get_where('dp_temp_cart_detail', array('tcd_session_cart' => $session_cart_rba));

            if ($get_cart_detail->num_rows() == 0) {
                redirect(base_url('product'));
            }
            $data['get_cart']       = $get_cart;
            $data['get_cart_detail']= $get_cart_detail;
            $data['content']        = 'cart/cart_shopping.php';
            $this->load->view('index', $data);
        } else {
            redirect(base_url('product'));
        }
    }
    
    public function addToCart() {
        $lockcode               = $this->input->post('lockcode');
        $cart_qty               = $this->input->post('cart_qty');
        $LANG                   = GET_CURRENT_LANG();
        $cart_code              = get_cart_code();
        $product                = get_product($lockcode);
        $product_detail         = get_product_detail($lockcode);
        
        if ($this->session->userdata('session_cart_rba') == false) {
            $this->session->set_userdata('session_cart_rba', md5(getDateTime()));
            
            $session_cart_rba                       = $this->session->userdata('session_cart_rba');
        } else {
            $session_cart_rba                       = $this->session->userdata('session_cart_rba');
        }

        if ($this->session->userdata('member_login') == TRUE) {
            $member_detail          = get_member_data($this->session->userdata('member_login')['member_email']);
            
            $temp_cart['temp_cart_name']        = $member_detail->member_name;
            $temp_cart['temp_cart_email']       = $member_detail->member_email;
            $temp_cart['temp_cart_phone']       = $member_detail->member_mobile;
            $temp_cart['temp_cart_addrs']       = $member_detail->member_address;
            $temp_cart['temp_cart_poscode']     = $member_detail->member_poscode;
        } 
        
        $temp_cart['temp_cart_book_code']       = $cart_code;
        $temp_cart['temp_cart_session_cart']    = $session_cart_rba;
        
        $check_temp_cart            = $this->db->get_where('dp_temp_cart', array('temp_cart_session_cart' => $session_cart_rba));
        if ($check_temp_cart->num_rows() < 1) {
            $this->db->insert('dp_temp_cart', $temp_cart);
        }
        
        $temp_cart_detail['tcd_session_cart']      = $session_cart_rba;
        $temp_cart_detail['tcd_product_sku']       = $product_detail->detail_product_sku;
        $temp_cart_detail['tcd_product_lockcode']  = $lockcode;
        $temp_cart_detail['tcd_product_qty']       = $cart_qty;
        
        $check_temp_cart_detail     = $this->db->get_where('dp_temp_cart_detail', array('tcd_session_cart' => $session_cart_rba, 'tcd_product_lockcode' => $lockcode));
        
        if ($check_temp_cart_detail->num_rows() > 0) {
            $exist_qty          = $check_temp_cart_detail->row()->tcd_product_qty;
            $temp_cart_detail['tcd_product_qty']    = $cart_qty + $exist_qty;
            
            $this->db->where('tcd_session_cart', $session_cart_rba);
            $this->db->where('tcd_product_lockcode', $lockcode);
            $this->db->update('dp_temp_cart_detail', $temp_cart_detail);
        } else {
            $this->db->insert('dp_temp_cart_detail', $temp_cart_detail);
        }
        
        echo "success";
    }
    
    public function checkout() {
        if ($this->session->userdata('session_cart_rba') != false) {
            $checkout_type                  = $this->uri->segment(3);
            $session_cart_rba               = $this->session->userdata('session_cart_rba');
            $data['LANG']                   = GET_CURRENT_LANG();
            $data['data_shipping']          = $this->db->query('SELECT * FROM dp_shipping GROUP BY shipping_country');

            $get_cart                       = $this->db->get_where('dp_temp_cart', array('temp_cart_session_cart' => $session_cart_rba));
            $get_cart_detail                = $this->db->get_where('dp_temp_cart_detail', array('tcd_session_cart' => $session_cart_rba));

            if ($this->session->userdata('sess_member_rba') == false) {
                if($checkout_type == 'guest') {
                    $data['checkout_type']  = $checkout_type;
                    $data['content']        = 'cart/cart_checkout.php';
                } else {
                    $data['content']        = 'cart/cart_checkout_login.php';
                }
            } else {
                if ($get_cart_detail->num_rows() == 0) {
                    redirect(base_url('product'));
                }
                $data['checkout_type']      = 'member';
                $data['content']            = 'cart/cart_checkout.php';
                $data['member_detail']      = get_member_data($this->session->userdata('sess_member_rba')['member_email']);
            }

            $data['get_cart']               = $get_cart;
            $data['get_cart_detail']        = $get_cart_detail;
            $this->load->view('index', $data);
        } else {
            redirect(base_url('product'));
        }
    }
    
    public function finish_order() {
        $session_cart_rba                  = $this->session->userdata('session_cart_rba');
        
        foreach ($this->input->post() as $key=>$val):
            if ($this->db->field_exists($key, 'dp_cart')) {
                $cart_data[$key]     = $val;
            }
        endforeach;
        $cart_data['cart_shipping_date']    = date('Y-m-d');
        $cart_data['cart_status']           = 'P';
        
        $this->db->insert('dp_cart', $cart_data); 
        
        $get_cart_temp                 = $this->db->get_where('dp_temp_cart', array('temp_cart_session_cart' => $session_cart_rba))->row();
        $get_cart_temp_detail          = $this->db->get_where('dp_temp_cart_detail', array('tcd_session_cart' => $session_cart_rba));
        
        foreach ($get_cart_temp_detail->result() as $cart_temp_detail):
            foreach($cart_temp_detail as $key=>$val):
                $key = (str_replace('tcd', 'cdp', $key));
              
                if ($key == 'cdp_uid') { continue; }
                $data_cart_detail[$key] = $val;
            endforeach;

            $this->db->insert('dp_cart_detail', $data_cart_detail); 
            $this->db->query("UPDATE dp_product_detail SET detail_product_stock = `detail_product_stock` - '".$cart_temp_detail->tcd_product_qty."' WHERE detail_product_sku = '".$cart_temp_detail->tcd_product_sku."'");
        endforeach;
        
        // SEND EMAIL NOTIF ORDER CONFIRMATION
        $get_email_template         = $this->db->get_where('dp_email', array('email_flag' => 'EMAIL_ORDER_CONFIRMATION', 'email_lang' => GET_CURRENT_LANG()['code']))->row();
        
        $order_detail_email         = "<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"2\" style=\"border: 1px solid #CCC\">";
        $order_detail_email         .= "<tr>";
        $order_detail_email         .= "    <th width=\"30px\" style=\"border-bottom: 1px solid #CCC\">QTY</th>";
        $order_detail_email         .= "    <th style=\"border-bottom: 1px solid #CCC\">ITEM</th>";
        $order_detail_email         .= "    <th width=\"20px\" style=\"border-bottom: 1px solid #CCC\"></th>";
        $order_detail_email         .= "    <th width=\"120px\" style=\"border-bottom: 1px solid #CCC\">PRICE</th>";
        $order_detail_email         .= "</tr>";

        foreach ($get_cart_temp_detail->result() as $cart_temp_detail):
            $product                = get_product($cart_temp_detail->tcd_product_lockcode);
            $product_detail         = get_product_detail($cart_temp_detail->tcd_product_lockcode);
            $product_price          = get_product_price($cart_temp_detail->tcd_product_lockcode);

            $price_cart_item        = $cart_temp_detail->tcd_product_qty * $product_price['price'];

            if (GET_CURRENT_CURRENCY()['code'] == 'USD') {
                $price        = number_format(($price_cart_item), 2, '.', ',');
            } else {
                $price        = number_format(($price_cart_item), 0, '.', ',');
            }
        
            $order_detail_email   .= "<tr>";
            $order_detail_email   .= "<td align=\"center\">".$cart_temp_detail->tcd_product_qty."</td>";
            $order_detail_email   .= "<td align=\"center\">".$product->product_name;
            $order_detail_email   .= "<td align=\"center\">".GET_CURRENT_CURRENCY()['code']."</td>";
            $order_detail_email   .= "<td align=\"right\">".$price.",-</td>";
            $order_detail_email   .= "</tr>";
        endforeach;
        $order_detail_email         .= "</table>";        

        if (GET_CURRENT_CURRENCY()['code'] == 'USD') {
            $price_subtotal         = number_format($get_cart_temp->temp_cart_subtotal_price, 2, '.', ',');
            $price_total            = number_format($get_cart_temp->temp_cart_total_price, 2, '.', ',');
            $voucher_nominal        = number_format($get_cart_temp->temp_cart_vch_nominal, 2, '.', ',');
            $shipping_fee           = number_format(floatval($get_cart_temp->temp_cart_shipping_fee), 2, '.', ',');
        } else {
            $price_subtotal         = number_format($get_cart_temp->temp_cart_subtotal_price, 0, '.', ',');
            $price_total            = number_format($get_cart_temp->temp_cart_total_price, 0, '.', ',');
            $voucher_nominal        = number_format($get_cart_temp->temp_cart_vch_nominal, 0, '.', ',');
            $shipping_fee           = number_format(floatval($get_cart_temp->temp_cart_shipping_fee), 0, '.', ',');
        }
        
        $email_message              = $get_email_template->email_message;

        $email_nickname             = $get_email_template->email_nickname;
        $email_sender               = $get_email_template->email_sender;
        $email_to                   = $get_cart_temp->temp_cart_email;
        $email_subject              = $get_email_template->email_subject;
        $email_cc                   = $get_email_template->email_cc;
        $email_bcc                  = $get_email_template->email_bcc;
        $email_subject              = $get_email_template->email_subject;
        
        $ship_address               = $get_cart_temp->temp_cart_shipping_name."<br />".
                                      $get_cart_temp->temp_cart_shipping_address."<br/ >".
                                      $get_cart_temp->temp_cart_shipping_kecamatan."<br/ >".
                                      $get_cart_temp->temp_cart_shipping_kabupaten." - ".$get_cart_temp->temp_cart_shipping_propinsi."<br/ >".
                                      $get_cart_temp->temp_cart_shipping_country." - ".$get_cart_temp->temp_cart_shipping_poscode."<br/ >".
                                      $get_cart_temp->temp_cart_shipping_phone;

        $email_message              = str_replace('[orderid]', $get_cart_temp->temp_cart_book_code, $email_message);
        $email_message              = str_replace('[tag_name]', $get_cart_temp->temp_cart_name, $email_message);
        $email_message              = str_replace('[tag_email]', $get_cart_temp->temp_cart_email, $email_message);
        $email_message              = str_replace('[tag_mobile]', $get_cart_temp->temp_cart_phone, $email_message);
        $email_message              = str_replace('[tag_ship_address]', $ship_address, $email_message);
        $email_message              = str_replace('[tag_list_order]', $order_detail_email, $email_message);
        
        $email_message              = str_replace('[tag_currency]', GET_CURRENT_CURRENCY()['code'], $email_message);
        $email_message              = str_replace('[tag_total_purchase]', $price_subtotal.',-', $email_message);
        $email_message              = str_replace('[tag_vch]', $voucher_nominal.',-', $email_message);
        $email_message              = str_replace('[tag_shipping]', $shipping_fee.',-', $email_message);
        $email_message              = str_replace('[tag_grand_total]', $price_total.',-', $email_message);
        
        //====================================================================================================
        sendEmail($email_nickname, $email_sender, $email_to, $email_subject, $email_message, $email_cc, $email_bcc);
        //====================================================================================================    
        
        // DELETE TEMP CART
        $this->db->delete('dp_temp_cart', array('temp_cart_session_cart' => $session_cart_rba));

        // DELETE TEMP CART DETAIL
        $this->db->delete('dp_temp_cart_detail', array('tcd_session_cart' => $session_cart_rba));

        $this->session->unset_userdata('session_cart_rba');
        
        $data['LANG']               = GET_CURRENT_LANG();
        $data['content']            = 'cart/cart_success.php';
        $this->load->view('index', $data);
    }

    function updateCart() {
        $uid = $this->input->post('uid');
        $qty = $this->input->post('qty');
        
        $update['tcd_product_qty']     = $qty;

        $this->db->where('tcd_uid', $uid);
        $update_cart = $this->db->update('dp_temp_cart_detail', $update);
        
        echo $update_cart;
    }

    function deleteCart() {
        $cart_uid    = $this->input->post('uid');
        $delete_cart = $this->db->query("DELETE FROM dp_temp_cart_detail WHERE tcd_uid = '".$cart_uid."'");
        echo $delete_cart;
    }
    
}