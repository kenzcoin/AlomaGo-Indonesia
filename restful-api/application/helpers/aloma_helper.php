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
		$x = explode('.',$fileimage);

		return $key1.'-'.$key2.'-'.$key3.'.'.end($x);
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

			case 'authentication':
				$query = $CI->db
				->get_where('authentication', array('key' => $token));

					return $query->num_rows() > 0 ? true : false;
			break;
		}
	}
}

if(!function_exists('checkMime')) 
{
    function checkMime($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

if ( ! function_exists('createSlug'))
{
	function createSlug($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	 	 // transliterate
	  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  	// remove unwanted characters
	  	$text = preg_replace('~[^-\w]+~', '', $text);

	  	// trim
	  	$text = trim($text, '-');

	 	 // remove duplicate -
	  	$text = preg_replace('~-+~', '-', $text);

	  	// lowercase
	 	 $text = strtolower($text);

	  	if (empty($text)) {
	    	return 'n-a';
	 	}

	  	return $text;
	}
}

if ( ! function_exists('createInvoice'))
{
	function createInvoice()
	{
		$CI =& get_instance();

		$query = $CI->db->get('transfer_pulsa')->result();

		$string = "AG";
		$now = 0;

		for ($i = 0; $i < 6; $i++) 
		{
		    $now .= mt_rand(0,9);
		}

		foreach($query as $row)
		{
			if ( $row->invoice == $now)
			{
				$now .= mt_rand(0,9);
			}
		}

		return $string.$now;
	}
}

/* End of file aloma_helper.php */
/* Location: ./application/helpers/aloma_helper.php */