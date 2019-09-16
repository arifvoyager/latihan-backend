<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Raeka22
 * @copyright 2015
 */
function upload_image($post_name, $width = 0, $height = 0, $file_path = '') {
    $CI = get_instance();
    //UPLOAD IMAGES
    $CI->load->library('upload');
    $FILES_NAME = $_FILES[$post_name];
    if($FILES_NAME['error'] == 0) {
        //upload and update the file
        if ($file_path == '') {
            $config['upload_path'] 			= './pubs/uploads/';
        } else {
            $config['upload_path'] 			= $file_path;
        }
        $config['allowed_types'] 		= 'png|jpg|jpeg|gif|bmp';
        $config['overwrite'] 			= false;
        $config['remove_spaces'] 		= true;
        $config['encrypt_name'] 		= true;
        $config['max_size']				= '5000';// in KB

        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload($post_name)) {
            echo $CI->upload->display_errors();

        } else {

            //Image Resizing
            $cover['source_image'] 	    = $CI->upload->upload_path.$CI->upload->file_name;
            $cover['maintain_ratio'] 	= FALSE;

            if ($width != 0) { $cover['width'] = $width; }
            if ($height != 0) { $cover['height'] = $height; }

            $CI->load->library('image_lib', $cover);
            if (!$CI->image_lib->resize()) {
                echo $CI->upload->display_errors();
            } else {
                $file_name    = $CI->upload->file_name;
            }
        }
    }
    
    return $file_name;
}

function upload_image_product($post_name, $width = 0, $height = 0) {
    $CI = get_instance();
    $file_name  = '';
    //UPLOAD IMAGES
    $CI->load->library('upload');
    $FILES_NAME = $_FILES[$post_name];
    if($FILES_NAME['error'] == 0) {
        //upload and update the file
        $config['upload_path'] 			= './pubs/uploads/products/';
        $config['allowed_types'] 		= 'png|jpg|jpeg|gif|bmp';
        $config['overwrite'] 			= false;
        $config['remove_spaces'] 		= true;
        $config['encrypt_name'] 		= true;
        $config['max_size']				= '5000';// in KB

        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload($post_name)) {
            echo $CI->upload->display_errors();

        } else {

            //Image Resizing
            $cover['source_image'] 	    = $CI->upload->upload_path.$CI->upload->file_name;
            $cover['maintain_ratio'] 	= FALSE;

            if ($width != 0) { $cover['width'] = $width; }
            if ($height != 0) { $cover['height'] = $height; }

            $CI->load->library('image_lib', $cover);
            if (!$CI->image_lib->resize()) {
                echo $CI->upload->display_errors();
            } else {
                $file_name    = $CI->upload->file_name;
            }
        }
    }

    return $file_name;
}

function makeChunk($str, $len, $end = '')
{
	//Write.flare(Server.HTMLEncode(str));
	if (!$str) $str = "";
	if (!$len) $len = 50;

	if(strlen($str) > $len){
		$str2 = $str;
		
		$str = substr($str, 0, $len);

		if(strrpos($str, " ") > -1){
			$str = substr($str, 0, strrpos($str, " "));
		}
		
		$str .= $end;
	}

	return $str;		
}

function get_member_data($member_username) {
    $CI                 = get_instance();
    
    $get_member_detail  = $CI->db->get_where('cd_member', array('member_username' => $member_username));
    
    return  $get_member_detail->row();
}

?>