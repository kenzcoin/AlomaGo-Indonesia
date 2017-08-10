<?php

if ( ! function_exists('message'))
{
	function message($errorString , $lang = 'id')
	{
		$messageId = array(
				'ErrorParameter' => "Parameter tidak ditemukan!",
                'ErrorToken' => "Access token tidak valid!",
                'WrongToken' => "Access token salah atau tidak ditemukan!",
                'WrongMethod' => 'Metode salah atau tidak ditemukan!',
                'NullField' => "Masih ada parameter yang kosong!"
			);

		$messageEn = array(
				'ErrorParameter' => "Parameter not found!",
                'ErrorToken' => "Access token not valid!",
                'WrongToken' => "Wrong or not found access token!",
                'WrongMethod' => 'Wrong method or not found!',
                'NullField' => "Parameter not valid!"
			);
		
		return ($lang == 'id') ? $messageId[$errorString] : $messageEn[$errorString];
	}
}