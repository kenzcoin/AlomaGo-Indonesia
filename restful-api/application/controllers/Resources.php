<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Resources extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->msgErrorParameter = "Parameter tidak ditemukan!";
		$this->msgErrorToken = "Access token tidak valid!";
		$this->msgWrongToken = "Access token salah atau tidak ditemukan!";
		$this->msgWrongPin = "PIN salah!";
		$this->msgFieldNull = "Field masih ada yang kosong!";
		$this->msgMethodNotAllowed = "Metode salah atau tidak ditemukan!";
		$this->msgRowIsNull = "Data masih kosong!";
		$this->msgInputSuccess = 'Berhasil input data!';
	}
	public function testRunOnReceive(){
		echo "test";
	}
	public function index_get($action = '')
	{
		$this->token = $this->get('token');
		$this->role = 'user';
		$authToken = authToken($this->role , $this->token);
		if ( $action != null)
		{

			if ( ! $this->token)
			{
				$response = array(
						'return' => false,
						'error_message' => $this->msgErrorToken
					);
			}
			else
			{
				switch( trimLower($action))
				{
					case 'user':
						$role = $this->get('role');

						if ( ! $role)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgErrorParameter
								);
						}
						else
						{
							switch( trimLower($role))
							{
								case 'user':
									if ( ! $authToken)
									{
										$response = array(
												'return' => false,
												'error_message' => $this->msgWrongToken
											);
									}
									else
									{
										$response = array(
												'return' => true,
												'data' => $authToken
											);
									}
								break;

								case 'admin':
									$this->role = 'admin';
									if ( ! $authToken)
									{
										$response = array(
												'return' => false,
												'error_message' => $this->msgWrongToken
											);
									}
									else
									{
										$response = array(
												'return' => true,
												'data' => $authToken
											);
									}
								break;
							}
							
						}
					break;

					case 'berita':
						if ( ! $authToken)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgWrongToken
								);
						}
						else
						{
							$query = $this->db->get('berita');

							$data = array();

							foreach($query->result() as $row)
							{
								$data[] = array(
										'id' => $row->id,
										'judul' => $row->judul,
										'content' => $row->content,
										'author' => $row->author,
										'slug' => $row->slug,
										'tanggal_berita' => $row->tanggal_waktu,
										'terakhir_diubah' => $row->terakhir_diubah,
									);
							}

							$num = $query->num_rows() > 0;

							$response = array(
									'return' => $num ? true : false,
									$num ? 'data' : 'error_message' 
									=> $num ? $query->result() : $this->msgRowIsNull
								);
						}
					break;

					case 'transaksi':
						if ( ! $authToken)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgWrongToken
								);
						}
						else
						{
							$listMetode = array('lastweek' , 'last','all');

							$this->metodeTransaksi = $this->get('method');
							$userdata = $authToken;
							
							/* Seleksi semua data terbaru */
							$queryAll = $this->db->from('transaksi')
							->where( array('id_user' => $userdata['id']))
							->order_by('tanggal_waktu DESC')
							->get();
							/* Seleksi semua data terbaru */

							/* Seleksi semua data terbaru per minggu terakhir */
							$sqlLastWeek = "SELECT * FROM transaksi WHERE 
							tanggal_waktu BETWEEN date_sub(now(), INTERVAL 1 WEEK) 
							and now() ORDER BY tanggal_waktu DESC";
							$queryLastWeek = $this->db->query($sqlLastWeek);
							/* Seleksi semua data terbaru per minggu terakhir */

							/* Seleksi satu data terbaru dari transaksi */
							$queryLast = $this->db->from('transaksi')
							->where( array('id_user' => $userdata['id']))
							->order_by('tanggal_waktu DESC')
							->limit(1)
							->get();
							/* Seleksi satu data terbaru dari transaksi */

							$data = array();

							$isQuery = ($this->metodeTransaksi == 'all') ? $queryAll->result() 
							: ( $this->metodeTransaksi == 'lastweek' ? $queryLastWeek->result() : $queryLast->result());

							foreach($isQuery as $row)
							{
								$data[] = array(
										'id' => $row->id,
										'id_bpjs' => $row->id_bpjs,
										'id_pln' => $row->id_pln,
										'nomer_tujuan' => $row->nomer_tujuan,
										'no_hp' => $row->no_hp,
										'tipe' => $row->tipe,
										'nominal' => $row->nominal,
										'tanggal_waktu' => $row->tanggal_waktu
									);
							}

							$isMetode = ( in_array($this->metodeTransaksi, $listMetode));
							$response = array(
									'return' => $isMetode ? 'true' : 'false',
									$isMetode ? 'data' : 'error_message' 
									=> $isMetode ? $data : $this->msgMethodNotAllowed
								);
						}
					break;

					default:
						$response = array(
								'return' => false,
								'error_message' => $this->msgErrorParameter
							);
					break;
				}
			}
		}
		else
		{
			$response = array(
					'return' => false,
					'error_message' => $this->msgErrorParameter
				);
		}

		$this->response($response);
	}

	public function index_post($action = '')
	{
		$this->token = $this->post('token');
		$this->role = 'user';
		$this->pinIsView = true;
		$authToken = authToken($this->role , $this->token , $this->pinIsView);
		switch( trimLower($action))
		{
			case 'transaksi':
				$this->metode = $this->post('metode');
				$availableMethod = array('transfer_pulsa' , 'tukar_pulsa' , 'beli_pulsa' , 'pembayaran_pln' , 'pembayaran_bpjs');

				$this->responseFailed = array(
						'return' => false,
						'error_message' => $this->msgFieldNull
					); 

				if ( ! $authToken)
				{
					$response = array(
							'return' => false,
							'error_message' => $this->msgWrongToken
						);
				}

				elseif( ! $this->metode)
				{
					$response = $this->responseFailed;
				}

				elseif ( ! in_array($this->metode , $availableMethod))
				{
					$response = array(
						'return' => false,
						'error_message' => $this->msgMethodNotAllowed
					);
				}

				else
				{
					$userdata = $authToken;
					$this->nothing = "nothing";
					switch ( trimLower($this->metode)) {
						case 'transfer_pulsa':
							$postdata = array(
									'nomer_tujuan' => $this->post('nomer_tujuan'),
									'nominal' => $this->post('nominal')
								);

							if ( ! $postdata['nomer_tujuan'] || ! $postdata['nominal'])
							{
								$response = $this->responseFailed;
							}
							else
							{
								$data = array(
										'id_user' => $userdata['id'],
										'nomer_tujuan' => $postdata['nomer_tujuan'],
										'nominal' => $postdata['nominal']
									);

								$this->db->insert('transfer_pulsa' , $data);

								$response = array(
										'return' => true,
										'message' => $this->msgInputSuccess
									);
							}
						break;

						case 'tukar_pulsa':
							$postdata = array(
									'nomer_rekening' => $this->post('nomer_rekening'),
									'bank' => $this->post('bank'),
									'nominal' => $this->post('nominal')
								);

							if ( ! $postdata['nomer_rekening'] || ! $postdata['bank'] || ! $postdata['nominal'])
							{
								$response = $this->responseFailed;
							}
							else
							{
								$data = array(
										'id_user' => $userdata['id'],
										'nomer_rekening' => $postdata['nomer_rekening'],
										'bank' => $postdata['bank'],
										'nominal' => $postdata['nominal']
									);

								$this->db->insert('tukar_pulsa' , $data);

								$response = array(
										'return' => true,
										'message' => $this->msgInputSuccess
									);
							}
						break;

						case 'beli_pulsa':
							$postdata = array(
									'no_tujuan' => $this->post('no_tujuan'),
									'tipe' => $this->post('tipe'),
									'nominal' => $this->post('nominal'),
									'pin' => $this->post('pin')
								);

							if ( ! $postdata['no_tujuan'] || ! $postdata['tipe'] 
								|| ! $postdata['nominal'] || ! $postdata['pin'])
							{
								$response = $this->responseFailed;
							}
							elseif($postdata['pin'] != $userdata['pin'])
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgWrongPin
									);
							}
							else
							{
								$tipe = strtolower(ucwords($postdata['tipe']));

								$data = array(
										'id_user' => $userdata['id'],
										'nomer_tujuan' => $postdata['no_tujuan'],
										'tipe' => $tipe,
										'nominal' => $postdata['nominal']
									);

								$this->db->insert('transaksi' , $data);

								$response = array(
										'return' => true,
										'message' => $this->msgInputSuccess
									);
							}
						break;

						case 'pembayaran_pln':
							$postdata = array(
									'id_pelanggan' => $this->post('id_pelanggan'),
									'nominal' => $this->post('nominal'),
									'pin' => $this->post('pin')
								);

							if ( ! $postdata['id_pelanggan'] || ! $postdata['pin'] || ! $postdata['nominal'])
							{
								$response = $this->responseFailed;
							}
							elseif($postdata['pin'] != $userdata['pin'])
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgWrongPin
									);
							}
							else
							{
								$data = array(
										'id_user' => $userdata['id'],
										'id_pln' => $postdata['id_pelanggan'],
										'tipe' => 'PLN',
										'nominal' => $postdata['nominal']
									);

								$this->db->insert('transaksi' , $data);

								$response = array(
										'return' => true,
										'message' => $this->msgInputSuccess
									);
							}
						break;

						case 'pembayaran_bpjs':
							$postdata = array(
									'id_bpjs' => $this->post('id_bpjs'),
									'no_hp' => $this->post('no_hp'),
									'pin' => $this->post('pin'),
									'nominal' => $this->post('nominal')
								);

							if ( ! $postdata['id_bpjs'] || ! $postdata['no_hp'] 
								|| ! $postdata['pin'] || ! $postdata['nominal'])
							{
								$response = $this->responseFailed;
							}
							elseif($postdata['pin'] != $userdata['pin'])
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgWrongPin
									);
							}
							else
							{
								$data = array(
										'id_user' => $userdata['id'],
										'id_bpjs' => $postdata['id_bpjs'],
										'no_hp' => $postdata['no_hp'],
										'tipe' => 'BPJS',
										'nominal' => $postdata['nominal']
									);

								$this->db->insert('transaksi' , $data);

								$response = array(
										'return' => true,
										'message' => $this->msgInputSuccess
									);
							}
						break;
						
						default:
							$response = array(
								'return' => false,
								'error_message' => $this->msgErrorParameter
							);
						break;
					}
				}
			break;

			default:
				$response = array(
					'return' => false,
					'error_message' => $this->msgErrorParameter
				);
			break;
		}

		$this->response($response);
	}

}

/* End of file Resources.php */
/* Location: ./application/controllers/Resources.php */