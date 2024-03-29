<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_random_password'))
{
    /**
     * Generate a random password. 
     * 
     * get_random_password() will return a random password with length 6-8 of lowercase letters only.
     *
     * @access    public
     * @param    $chars_min the minimum length of password (optional, default 6)
     * @param    $chars_max the maximum length of password (optional, default 8)
     * @param    $use_upper_case boolean use upper case for letters, means stronger password (optional, default false)
     * @param    $include_numbers boolean include numbers, means stronger password (optional, default false)
     * @param    $include_special_chars include special characters, means stronger password (optional, default false)
     *
     * @return    string containing a random password 
     */    
    function getRandom($chars_min=20, $chars_max=25, $use_upper_case=false, $include_numbers=true, $include_special_chars=false)
    {
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxzAEUEOBCDEFGHIJKLMNOPQRTSUVWXZY';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                

      return $password;
    }

    function GeraHashNumeric($qtd){
    //Under the string $Caracteres you write all the characters you want to be used to randomly generate the code.
    	$Caracteres = '0123456789';
    	$QuantidadeCaracteres = strlen($Caracteres);
    	$QuantidadeCaracteres--;
    
    	$Hash=NULL;
    		for($x=1;$x<=$qtd;$x++){
    			$Posicao = rand(0,$QuantidadeCaracteres);
    			$Hash .= substr($Caracteres,$Posicao,1);
    		}
    
    	return $Hash;
    } 
}