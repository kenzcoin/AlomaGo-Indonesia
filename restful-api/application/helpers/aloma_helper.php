<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('trimLower'))
{
	function trimLower($string)
	{
		$string = trim($string);
		$string = strtolower($string);

		return $string;
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

if ( ! function_exists('generate_key'))
{
	function generate_key()
	{
		$key1 = substr( md5(uniqid(rand(), true)),0,10);
		$key2 = generate_string( rand(3,5));
		$key3 = strrev(strtotime( date('Y-m-d H:i:s')));
		return $key1.'-'.$key2.'-'.$key3;
	}
}

if ( ! function_exists('generate_image'))
{
	function generate_image($fileimage)
	{
		$key1 = substr( md5(uniqid(rand(), true)),0,15);
		$key2 = substr( md5($fileimage.time()),0,15);
		$key3 = random_string(15);
		// $x = explode('.',$fileimage);
		// $ext = count($x)-1;

		return $key1.'-'.$key2.'-'.$key3;
	}
}

if ( ! function_exists('authToken'))
{
	function authToken($role , $token , $pinIsView = false)
	{
		$CI =& get_instance();

		switch( trimLower($role))
		{
			case 'user':
				$query = $CI->db
				->get_where('user' , array('token' => $token));

				if ( $query->num_rows() > 0)
				{
					$data = array();

					foreach($query->result() as $row)
					{
						$data[] = array(
								'id' => $row->id,
								'nama' => $row->nama,
								'foto' => $row->foto,
								'token' => $row->token,
								$pinIsView ? 'pin' : 'x' 
								=> $pinIsView ? $row->pin : 'x',
								'tanggal' => $row->terdaftar,
							);
					}

					return $data[0];	
				}

				return false;
			break;

			case 'admin':

			break;
		}
	}
}

/* End of file aloma_helper.php */
/* Location: ./application/helpers/aloma_helper.php */