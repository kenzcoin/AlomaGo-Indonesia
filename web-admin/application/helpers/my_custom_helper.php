<?php

if ( !function_exists('trimLower'))
{
	function trimLower($string)
	{
		$string = trim($string);
		$string = strtolower($string);

		return $string;
	}
}

if ( ! function_exists('random_string'))
{
	function random_string($length) 
	{
	    $key = '';
	    $keys = array_merge(range(0, 9), range('a', 'z'));

	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }

	    return $key;
	}
}

if ( ! function_exists('generate_string'))
{
	function generate_string($length) {
	    $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRESTUVWXYZ"; // allowed chars in the password
	     if ($length == "" OR !is_numeric($length)){
	      $length = 8;
	     }

	     $i = 0; 
	     $password = ""; 
	     while ($i < $length) { 
	      $char = substr($possible, rand(0, strlen($possible)-1), 1);
	      if (!strstr($password, $char)) { 
	       $password .= $char;
	       $i++;
	       }
	      }
	     return $password;
	}
}

if ( ! function_exists('generate_key'))
{
	function generate_key()
	{
		$key1 = substr( md5(uniqid(rand(), true)),0,10);
		$key2 = generate_string('3');
		$key3 = strrev(strtotime( date('Y-m-d H:i:s')));
		$key4 = strrev(random_string('5'));
		return $key1.'-'.$key2.'-'.$key3.'-'.$key4;
	}
}

if ( ! function_exists('Rupiah'))
{
	function Rupiah($angka , $string = "Rp")
	{
		return $string.number_format($angka , 1 , ',' , '.');
	}
}

if ( ! function_exists('Nominal'))
{
	function Nominal($number)
	{
		if ( $number >= 1000000000000)
		{
			$output = ($number/1000000000000).'T';
		}
		elseif ( $number >= 1000000000)
		{
			$output = ($number/1000000000).'M';
		}
		elseif($number>=1000000){
			$output = ($number/1000000).'JT';
		}else if($number>=1000){
			$output = ($number/1000).'K';
		}
		else{
			$output = $number;
		}

		$x = explode('.', $output);

		return $x[0].( isset($x[1]) ? '.'.str_replace(0, '', $x[1]) : null);
	}
}