<?php

namespace App\Safety;



class DecryptageData
{
public static function datadecrypt($input)
    {
        $input=str_replace('[plus]','+',$input);
        $first_key = base64_decode($_ENV['FIRST_KEY']);
        // $second_key = base64_decode($_ENV['SECONDKEY']);           
        $mix = base64_decode($input);
       
        $method = "aes-256-cbc";   
        $iv_length = openssl_cipher_iv_length($method);
           
        $iv = substr($mix,0,$iv_length);
        // $iv = openssl_random_pseudo_bytes(16);
        $first_encrypted = substr($mix,$iv_length);
           
        $data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);

   
       return $data;
        
    }
}