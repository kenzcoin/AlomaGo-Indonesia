<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Run extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	function receive(){
		$data = $this->getAllNewSMS();
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				$pattern = $this->checkPattern($row['TextDecoded']);
				if ($pattern != 'false') {
					/*TP#XL#081xxxx#5000#5500*/
					$type = $pattern[0];
					$provider = $pattern[1];
					$nomor = $pattern[2];
					$nominal = $pattern[3];
					$total = $pattern[4];
					/*nomor tujuan*/
					/*nominal*/
					/*tanggal_waktu*/
					$dataInsert['nomer_tujuan'] = $nomor;
					$dataInsert['nominal'] = $nominal;
					$dataInsert['tanggal_waktu'] = gmdate("Y-m-d H:i:s");
					$insert = $this->db->insert('transfer_pulsa', $dataInsert);
					if ($insert) {
						$this->updateSMS($row['ID']);
					}
				}
			}
		}
	}


	function getAllNewSMS(){
		$data['Processed'] = 'false';
		$this->db->where($data);
		$db = $this->db->get('inbox');
		return $db;
	}

	function checkPattern($word){
		$allWord = explode("#", $word);
		if (count($allWord) > 1) {
			return $allWord;
		}else{
			return false;
		}
	}
	function updateSMS($id_inbox){
		$dataWhere['ID'] = $id_inbox;
		$dataUpdate['Processed'] = 'true';
		$this->db->where($dataWhere);
		$update = $this->db->update('inbox', $dataUpdate);
	} 
}