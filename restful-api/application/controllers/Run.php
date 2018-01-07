<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Run extends CI_Controller {
	private $urlHeadEndpoint;
	private $urlRequestEndpoint;
	private $username;
	private $password;
	public function __construct(){
		parent::__construct();
		$this->urlHeadEndpoint = "http://202.149.67.53:8081";
		// $this->urlHeadEndpoint = "http://202.149.67.53:8098";
		$this->urlRequestEndpoint = "/api/YtzService.asmx";
		$this->username = "aloma";
		$this->password = "Mb4aloma418263g";
	}
	function receive(){
		$data = $this->getAllNewSMS();
		if ($data->num_rows() > 0) {
			foreach ($data->result_array() as $row) {
				if ($row['SenderNumber'] == "151") {
					/*indosat*/
					/*cek apakah menerima transferan*/
					$pattern1 = " mentransfer pulsa sebesar Rp ";
					$pattern11 = " tgl ";
					$pattern2 = " adalah token anda. ";
					$word = $row['TextDecoded'];
					$resultPattern1 = $this->checkPattern($pattern1, $word);
					$resultPattern2 = $this->checkPattern($pattern2, $word);
					if ($resultPattern1 != false) {
						/*menerima transferan*/
						$nopengirim = $resultPattern1[0];
						$jumlahkirim = $this->checkPattern($pattern11, $resultPattern1[1])[0];
						/*validasi di table t_transfer pulsa*/
						$dataSelect['nomor_pengirim'] = $this->normalisasiNomor($nopengirim);
						$dataSelect['total_pulsa_transfer'] = $jumlahkirim;
						$dataSelect['verifikasi'] = "N";
						$this->db->where($dataSelect);
						$get = $this->db->get('t_transfer_pulsa');
						if ($get->num_rows() > 0) {
							/*data valid*/
							/*update ke Y (verifikasi)*/
							$dataUpdate['verifikasi'] = "Y";
							$dataSelectUpdate['id'] = $get->row()->id;
							$this->db->set($dataUpdate);
							$this->db->where($dataSelectUpdate);
							$update = $this->db->update('t_transfer_pulsa');
							if ($update) {
								/*berhasil verifikasi data*/
								/*send pulsa ke tujuan*/
								$this->doCheckTransfer();
								$this->updateSMS($row['ID']);
							}
						}
					}else if($resultPattern2 != false){
						$token = $resultPattern2[0];

						/*menerima token untuk transfer*/
						/*send YA atau OK <Token> ke CS*/
						$dataSelect['provider'] = "m3";
						$this->db->where($dataSelect);
						$get = $this->db->get("master_cs_provider");

						$message = "Ok ".$token;
						$csProvider = $get->row()->nomor;
						$provider = "m3";

						$sentKonfirmasi = $this->sentKonfirmasi($csProvider, $message, $provider);
						if ($sentKonfirmasi) {
							$this->updateSMS($row['ID']);
						}
					}
				}else if ($row['SenderNumber'] == "858") {
					/*telkomsel*/
					$pattern1 = "Anda mendapatkan penambahan pulsa Rp ";
					$pattern11 = " dari nomor ";
					$pattern2 = "Anda akan mengirimkan pulsa Rp ";
					$word = $row['TextDecoded'];
					$resultPattern1 = $this->checkPattern($pattern1, $word);
					$resultPattern2 = $this->checkPattern($pattern2, $word);
					if ($resultPattern1 != false) {
						$nopengirim = $this->normalisasiNomor($this->checkPattern($pattern11, $resultPattern1[1])[1]);
						$jumlahkirim = $this->checkPattern($pattern11, $resultPattern1[1])[0];
						/*validasi di table t_transfer pulsa*/
						$dataSelect['nomor_pengirim'] = $nopengirim;
						$dataSelect['total_pulsa_transfer'] = $jumlahkirim;
						$dataSelect['verifikasi'] = "N";
						$this->db->where($dataSelect);
						$get = $this->db->get('t_transfer_pulsa');
						if ($get->num_rows() > 0) {
							/*data valid*/
							/*update ke Y (verifikasi)*/
							$dataUpdate['verifikasi'] = "Y";
							$dataSelectUpdate['id'] = $get->row()->id;
							$this->db->set($dataUpdate);
							$this->db->where($dataSelectUpdate);
							$update = $this->db->update('t_transfer_pulsa');
							if ($update) {
								/*berhasil verifikasi data*/
								/*send pulsa ke tujuan*/
								$this->doCheckTransfer();
								$this->updateSMS($row['ID']);
							}
						}						
					}else if ($resultPattern2 != false) {
						$token = $resultPattern2[0];

						/*menerima token untuk transfer*/
						/*send YA atau OK <Token> ke CS*/
						$dataSelect['provider'] = "telkomsel";
						$this->db->where($dataSelect);
						$get = $this->db->get("master_cs_provider");

						$message = "YA";
						$csProvider = $get->row()->nomor;
						$provider = "telkomsel";

						$sentKonfirmasi = $this->sentKonfirmasi($csProvider, $message, $provider);
						if ($sentKonfirmasi) {
							$this->updateSMS($row['ID']);
						}						
					}
				}else if($row['SenderNumber'] == "168"){
					$pattern1 = "Anda menerima Pulsa dari ";
					$pattern11 = " sebesar Rp";
					$pattern111 = ".";
					$pattern2 = " Anda akan Bagi Pulsa ke no AXIS ";
					$pattern3 = " Anda akan Bagi Pulsa ke no XL ";
					$pattern233 = " sebesar ";
					$word = $row['TextDecoded'];
					$resultPattern1 = $this->checkPattern($pattern1, $word);
					$resultPattern2 = $this->checkPattern($pattern2, $word);
					// $resultPattern3 = $this->checkPattern($pattern3, $word);
					print_r($resultPattern1);
					print_r($resultPattern2);
					// print_r($resultPattern3);
					if ($resultPattern1 != false) {
						/*verifikasi tabel t_transfer_pulsa*/
						$nopengirim = $this->normalisasiNomor($this->checkPattern($pattern11, $resultPattern1[1])[0]);
						$jumlahkirim = $this->checkPattern($pattern111, $this->checkPattern($pattern11, $resultPattern1[1])[1])[0];
						/*validasi di table t_transfer pulsa*/
						$dataSelect['nomor_pengirim'] = $nopengirim;
						$dataSelect['total_pulsa_transfer'] = $jumlahkirim;
						$dataSelect['verifikasi'] = "N";					
						$this->db->where($dataSelect);
						$get = $this->db->get('t_transfer_pulsa');
						print_r($get->num_rows());
						if ($get->num_rows() > 0) {
							/*data valid*/
							/*update ke Y (verifikasi)*/
							$dataUpdate['verifikasi'] = "Y";
							$dataSelectUpdate['id'] = $get->row()->id;
							$this->db->set($dataUpdate);
							$this->db->where($dataSelectUpdate);
							$update = $this->db->update('t_transfer_pulsa');
							if ($update) {
								/*berhasil verifikasi data*/
								/*send pulsa ke tujuan*/
								$this->doCheckTransfer();
								$this->updateSMS($row['ID']);
							}
						}						
					}/*else if($resultPattern2 != false){
						$resultPattern23 = $this->checkPattern($pattern233, $resultPattern2[1]);
						if ($resultPattern23 != false) {
							$dataSelect['provider'] = "xl";
							$this->db->where($dataSelect);
							$get = $this->db->get("master_cs_provider");

							$message = "Y";
							$csProvider = $get->row()->nomor;
							$provider = "xl";

							$sentKonfirmasi = $this->sentKonfirmasi($csProvider, $message, $provider);
							if ($sentKonfirmasi) {
								$this->updateSMS($row['ID']);
							}							
						}
					}*//*else if($resultPattern3 != false){
						$resultPattern23 = $this->checkPattern($pattern233, $resultPattern3[1]);
						if ($resultPattern23 != false) {
							/*send konfirmation to 168*/
							/*menerima token untuk transfer*/
							/*send YA atau OK <Token> ke CS*/
/*							$dataSelect['provider'] = "xl";
							$this->db->where($dataSelect);
							$get = $this->db->get("master_cs_provider");

							$message = "Y";
							$csProvider = $get->row()->nomor;
							$provider = "xl";

							$sentKonfirmasi = $this->sentKonfirmasi($csProvider, $message, $provider);
							if ($sentKonfirmasi) {
								$this->updateSMS($row['ID']);
							}							
						}*/
					/*}*/
				}else{
					$this->updateSMS($row['ID']);
				}
			}
		}
	}
	function doCheckTransfer(){
		$dataSelect['verifikasi'] = "Y";
		$dataSelect['sent'] = "N";
		$this->db->where($dataSelect);
		$get = $this->db->get("t_transfer_pulsa");
		if ($get->num_rows() > 0) {
			foreach ($get->result_array() as $row) {
				$nomor_tujuan = $row['nomor_tujuan'];
				$cs = "087859637999";
				$provider = $this->getProvider($nomor_tujuan);
				$totaltransfer = $row['denominasi'];
				$message = $totaltransfer."*".$nomor_tujuan;
				$product_code = $this->getProductCode($totaltransfer, $provider);

				$dataInsert['TextDecoded'] = $message;
				$dataInsert['CreatorID'] = $getProvider;
				$dataInsert['SenderId'] = $getProvider;
				$dataInsert['DestinationNumber'] = $cs;
				$insertData = $this->sentPrivate($nomor_tujuan, $product_code, $this->user, $this->password);
				// $insertData = $this->db->insert('outbox', $dataInsert);
				if ($insertData) {
					$dataUpdate["sent"] = "Y";
					$dataWhere["id"] = $row['id'];
					$this->db->where($dataWhere);
					$this->db->replace("t_transfer_pulsa", $dataUpdate);
				}
			}
		}
	}
	function getProductCode($nominal, $provider){
		$dataSelect['nominal'] = $nominal;
		$dataSelect['provider'] = $provider;
		$this->db->where($dataSelect);
		$select = $this->db->get('product_code');
		return $select;
	}
	function getProvider($nomor){
		$kodeprefix = substr($nomor, 0, 4);
		$dataSelect = array();
		$dataSelect['prefix'] = $kodeprefix;
		$this->db->where($dataSelect);
		$get = $this->db->get('master_prefix_provider');
		if ($get->num_rows() > 0) {
			return $get->row()->provider;
		}
		return "tidak ditemukan";
	}
	function sendPulsa($tujuan, $nominal, $provider){
		// $dataInsert = array();
		// $CreatorID = "";
		// $SenderId = "";
		// $DestinationNumber = "";
		// $TextDecoded = "";
		// switch ($provider) {
		// 	case 'm3':
		// 		$TextDecoded = "TRANSFERPULSA ".$tujuan." ".$nominal;
		// 		$CreatorID= "m3";
		// 		$SenderId = "m3";
		// 		$DestinationNumber = "151";
		// 		break;
		// 	default:
		// 		# code...
		// 		break;
		// }
		// $dataInsert['TextDecoded'] = $TextDecoded;
		// $dataInsert['CreatorID'] = $CreatorID;
		// $dataInsert['SenderId'] = $SenderId;
		// $dataInsert['DestinationNumber'] = $DestinationNumber;
		// $insertData = $this->db->insert('outbox', $dataInsert);
		// if ($insertData) {
		// 	return true;
		// }else{
		// 	return false;
		// }
	}

	function getAllNewSMS(){
		$data['Processed'] = 'false';
		$this->db->where($data);
		$db = $this->db->get('inbox');
		return $db;
	}
	function testPattern(){
		$word = "Kejutan seru! Yuk Perbanyak transaksimu & menangkan liburan ke China periode Agt-Okt'17. Anda menerima Pulsa dari 6285941020493 sebesar Rp7000.";
		$resultPattern = $this->checkPattern("Anda menerima Pulsa dari ", $word);
		print_r($resultPattern);
		// echo $resultPattern[1];
		// print_r($this->checkPattern("sebesar Rp ", $resultPattern[1]));
	}
	function checkPattern($delimiter, $word){
		$allWord = explode($delimiter, $word);
		if (count($allWord) > 1) {
			return $allWord;
		}else{
			return false;
		}
	}
	function checkTokenIndosat($word){
		$allWord = explode("mentransfer pulsa sebesar", $word);
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
	function sentKonfirmasi($tujuan, $message, $provider){
		$dataInsert['DestinationNumber'] = $tujuan;
		$dataInsert['TextDecoded'] = $message;
		$dataInsert['SenderID'] = $provider;
		$dataInsert['CreatorID'] = $provider;
		$insert = $this->db->insert('outbox', $dataInsert);
		if ($insert) {
			return true;
		}
		return false;
	}
	function getCodePhoneNumber($phoneNumber){
		$phoneNumber = $this->normalisasiNomor($phoneNumber);
		echo $this->getProvider($phoneNumber);
	}
	function normalisasiNomor($nomor){
		$subnomor = substr($nomor, 0, 2);
		if($subnomor == "62"){
			$newNomor = substr($nomor, 2);
			return "0".$newNomor;
		}else{
			return $nomor;
		}
	}
	function sentKonfirm($phoneOrigin, $phoneDest, $denominasi, $totaltransfer){
		$dataInsert['nomor_pengirim'] = $phoneOrigin;
		$dataInsert['nomor_tujuan'] = $phoneDest;
		$dataInsert['denominasi'] = $denominasi;
		$dataInsert['total_pulsa_transfer'] = $totaltransfer;
		$insert = $this->db->insert('t_transfer_pulsa', $dataInsert);
		if ($insert) {
			return true;
		}
		return false;
	}
	function sentPrivate($notujuan, $kodeproduk, $user, $password){
		$return = $this->_sentMBA($notujuan, $kodeproduk, $this->username, $this->password);
		return $return;
	}
	function sampleMBA($notujuan, $kodeproduk){
		$return = $this->_sentMBA($notujuan, $kodeproduk, $this->username, $this->password);
		print_r($return);
	}
	function _sentMBA($notujuan, $kodeproduk, $user, $password){
		$returns = false;
		$client = new SoapClient(
			$this->urlHeadEndpoint."".$this->urlRequestEndpoint."?WSDL",
			array(
		        'location' => $this->urlHeadEndpoint."".$this->urlRequestEndpoint,
		        'trace' => 1,
		        'cache_wsdl' =>  WSDL_CACHE_NONE
		    ));
		// print_r($client);
		$params = new stdClass();
		$params->msisdn = $notujuan;
		$params->productCode = $kodeproduk;    
		$params->userID = $user;
		$params->userPassword = $password;    
		$params->clientRefID = $notujuan;
		$dataInsertLog = array();
		$dataInsertLog['date_add'] = date('Y-m-d');
		$dataInsertLog['params'] = json_encode($params);
		try {
		   	$result = $client->YtzTopupRequest($params);
			$dataInsertLog['response'] = $result;
			$returns = true;
		} catch (SoapFault $e) {
			$dataInsertLog['response'] = $e->getMessage();
		}		
		$this->db->insert('t_log_mba', $dataInsertLog);
		return $returns;
	}
	function checkPendingMBA(){
		phpinfo();
	}
	function updateStatusDeliver(){
	}
}
