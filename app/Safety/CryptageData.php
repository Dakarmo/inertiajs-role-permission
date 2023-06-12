<?php

namespace App\Safety;



class CryptageData
{
    public static function datacrypt($data)
    {
        $first_key = base64_decode($_ENV['FIRST_KEY']);
        // $second_key = base64_decode($_ENV['SECONDKEY']);   
   
        $method = "aes-256-cbc";   
        $iv_length = openssl_cipher_iv_length($method);
        $iv = openssl_random_pseudo_bytes($iv_length);
       
        $first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);   
        $output = base64_encode($iv.$first_encrypted);   
        $output = str_replace('+','[plus]',$output);
        
        return $output;        
    }
}