<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_product($lockcode) {
    $CI                 = get_instance();
    $product            = $CI->db->get_where('dp_product', array('product_lock_code' => $lockcode))->row();

    return  $product;
}

function get_product_by_category($cate_lock_code) {
    $CI                 = get_instance();
    $LANG               = GET_CURRENT_LANG();
    $cproduct           = $CI->db->get_where('dp_product_category', array('category_lock_code' => $cate_lock_code, 'category_lang' => $LANG['code']))->row();
    
    $product            = $CI->db->get_where('dp_product', array('product_category_'.$cproduct->category_level => $cate_lock_code, 'product_lang' => $LANG['code']));
    
    return $product;
}

function get_product_detail_by_lockcode($lockcode) {
    $CI = get_instance();
    
    $product_detail     = $CI->db->get_where('dp_product', array('product_lock_code' => $lockcode))->row();
    
    return $product_detail;
}

function get_product_detail_by_slug($pslug) {
    $CI = get_instance();
    
    $product_detail     = $CI->db->get_where('dp_product', array('product_slug' => $pslug))->row();
    
    return $product_detail;
}

function get_category($lockcode) {
    $CI                 = get_instance();
    $LANG               = GET_CURRENT_LANG();
    $product_category   = $CI->db->get_where('dp_product_category', array('category_lock_code' => $lockcode, 'category_lang' => $LANG['code']))->row();
    
    return $product_category->category_title;
}