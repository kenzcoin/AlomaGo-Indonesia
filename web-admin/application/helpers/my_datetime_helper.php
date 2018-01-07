<?php

if ( ! function_exists('humantime'))
{
	function humantime($datetime)
	{
		$x = strtotime($datetime);

		$string = null;

		$bulan = array(
				'Januari' , 'Februari' , 'Maret' , 'April' , 'Mei' , 'Juni' , 'Juli',
				'Agustus' , 'September' , 'Oktober' , 'November' , 'Desember'
 			);

		$day = array(
				'Mon' , 'Tue' , 'Wed' , 'Thu' , 'Fri' , 'Sat' , 'Sun'
			);

		$hari = array(
				'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'
			);

		$string .= $hari[array_search(date('D',$x), $day)].", ";
		$string .= date('d' , $x)." ";
		$string .= $bulan[str_replace('0', ' ', date('m' , $x)) - 1]." ";
		$string .= date('Y H:i' , $x);
		
		return $string;
	}
}