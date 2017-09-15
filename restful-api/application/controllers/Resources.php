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
		$this->msgNotAuthorized = 'You\'re not authorized!';
	}

	public function index_get($action = '' , $method = '')
	{
		$this->token = $this->get('auth');
		$this->role = 'authentication';
		$auth = authToken($this->role , $this->token);
		switch( trimLower($action))
		{
			/* Public */
			case 'public';
				switch( trimLower($method))
				{
					case 'kabar-burung':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							if ( ! $this->get('method'))
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgErrorParameter
									);
							}
							else
							{
								switch( trimLower($this->get('method')))
								{
									case 'list':
										$query = $this->db
										->from('berita')
										->order_by('tanggal_waktu DESC')
										->get();

										$row = $query->num_rows();

										if ( $row > 0)
										{
											$result = null;

											foreach($query->result() as $data)
											{
												$result[] = array(
														'judul' => $data->judul,
														'gambar' => $data->gambar,
														'content' => $data->content,
														'author' => $data->author,
														'slug' => $data->slug,
														'dilihat' => $data->dilihat,
														'tanggal_waktu' => array(
																'timestamp' => strtotime($data->tanggal_waktu),
																'real_datetime' => $data->tanggal_waktu,
																'human_datetime' => humantime($data->tanggal_waktu)
															),
														'terakhir_diubah' => array(
																'timestamp' => strtotime($data->terakhir_diubah),
																'real_datetime' => $data->terakhir_diubah,
																'human_datetime' => humantime($data->terakhir_diubah)
															),
														'key' => $data->key
													);
											}
										}

										$response = array(
												'return' => $row > 0 ? true : false,
												$row > 0 ? 'data' : 'error_message' =>
												$row > 0 ? $result : 'Data not found!'
											);
									break;	

									case 'detail':
										if ( ! $this->get('key'))
										{
											$response = array(
													'return' => false,
													'error_message' => $this->msgErrorParameter
												);
										}
										else
										{
											$query = $this->db
											->from('berita')
											->where( array('key' => $this->get('key')))
											->order_by('tanggal_waktu DESC')
											->get();

											$row = $query->num_rows();

											if ( $row > 0)
											{
												$result = null;

												foreach($query->result() as $data)
												{
													$result = array(
															'judul' => $data->judul,
															'gambar' => $data->gambar,
															'content' => $data->content,
															'author' => $data->author,
															'slug' => $data->slug,
															'dilihat' => $data->dilihat,
															'tanggal_waktu' => array(
																	'timestamp' => strtotime($data->tanggal_waktu),
																	'real_datetime' => $data->tanggal_waktu,
																	'human_datetime' => humantime($data->tanggal_waktu)
																),
															'terakhir_diubah' => array(
																	'timestamp' => strtotime($data->terakhir_diubah),
																	'real_datetime' => $data->terakhir_diubah,
																	'human_datetime' => humantime($data->terakhir_diubah)
																),
															'key' => $data->key
														);
												}
											}

											$response = array(
													'return' => $row > 0 ? true : false,
													$row > 0 ? 'data' : 'error_message' =>
													$row > 0 ? $result : 'Data not found!'
												);
										}
									break;

									case 'search':
										if ( ! $this->get('q'))
										{
											$response = array(
													'return' => false,
													'error_message' => $this->msgErrorParameter
												);
										}
										else
										{	
											$sql = "SELECT * FROM berita WHERE judul LIKE '%".$this->get('q')."%' 
													OR content LIKE '%".$this->get('q')."%'";
											$query = $this->db->query($sql);

											$num = $query->num_rows();

											if ( $num > 0 )
											{
												$result = null;

												foreach($query->result() as $data)
												{
													$result[] = array(
															'judul' => $data->judul,
															'gambar' => $data->gambar,
															'content' => $data->content,
															'author' => $data->author,
															'slug' => $data->slug,
															'dilihat' => $data->dilihat,
															'tanggal_waktu' => array(
																	'timestamp' => strtotime($data->tanggal_waktu),
																	'real_datetime' => $data->tanggal_waktu,
																	'human_datetime' => humantime($data->tanggal_waktu)
																),
															'terakhir_diubah' => array(
																	'timestamp' => strtotime($data->terakhir_diubah),
																	'real_datetime' => $data->terakhir_diubah,
																	'human_datetime' => humantime($data->terakhir_diubah)
																),
															'key' => $data->key
														);
												}
											}

											$response = array(
													'return' => $num > 0 ? true : false,
													$num > 0 ? 'data' : 'error_message' =>
													$num > 0 ? $result : 'Data kabar burung tidak ditemukan',
												);
										}
									break;

									case 'top':
										$limit = $this->get('limit') ?
										$this->get('limit') : 5;

										$query = $this->db
										->from('berita')
										->order_by('dilihat DESC , tanggal_waktu DESC')
										->limit($limit)
										->get();

										$row = $query->num_rows();

										if ( $row > 0)
										{
											$result = null;

											foreach($query->result() as $data)
											{
												$result[] = array(
														'judul' => $data->judul,
														'gambar' => $data->gambar,
														'content' => $data->content,
														'author' => $data->author,
														'slug' => $data->slug,
														'dilihat' => $data->dilihat,
														'tanggal_waktu' => array(
																'timestamp' => strtotime($data->tanggal_waktu),
																'real_datetime' => $data->tanggal_waktu,
																'human_datetime' => humantime($data->tanggal_waktu)
															),
														'terakhir_diubah' => array(
																'timestamp' => strtotime($data->terakhir_diubah),
																'real_datetime' => $data->terakhir_diubah,
																'human_datetime' => humantime($data->terakhir_diubah)
															),
														'key' => $data->key
													);
											}
										}

										$response = array(
												'return' => $row > 0 ? true : false,
												$row > 0 ? 'data' : 'error_message' =>
												$row > 0 ? $result : 'Data not found!'
											);
									break;
								}
							}
						}
					break;

					case 'about':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$query = $this->db->get_where('app_info', array(
									'key' => 'about'
								));	

							$row = $query->num_rows();

							if ( $row > 0)
							{
								$result = null;

								foreach($query->result() as $data)
								{
									$result = array(
											'title' => $data->name,
											'content' => $data->content,
											'last_modified' => $data->last_modified
										);
								}
							}

							$response = array(
									'return' => $row > 0 ? true : false,
									$row > 0 ? 'data' : 'error_message' =>
									$row > 0 ? $result : 'Data not found!'
								);
						}
					break;

					case 'privacy':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$query = $this->db->get_where('app_info', array(
									'key' => 'privacy'
								));	

							$row = $query->num_rows();

							if ( $row > 0)
							{
								$result = null;

								foreach($query->result() as $data)
								{
									$result = array(
											'title' => $data->name,
											'content' => $data->content,
											'last_modified' => $data->last_modified
										);
								}
							}

							$response = array(
									'return' => $row > 0 ? true : false,
									$row > 0 ? 'data' : 'error_message' =>
									$row > 0 ? $result : 'Data not found!'
								);
						}
					break;

					case 'disclaimer':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$query = $this->db->get_where('app_info', array(
									'key' => 'disclaimer'
								));	

							$row = $query->num_rows();

							if ( $row > 0)
							{
								$result = null;

								foreach($query->result() as $data)
								{
									$result = array(
											'title' => $data->name,
											'content' => $data->content,
											'last_modified' => $data->last_modified
										);
								}
							}

							$response = array(
									'return' => $row > 0 ? true : false,
									$row > 0 ? 'data' : 'error_message' =>
									$row > 0 ? $result : 'Data not found!'
								);
						}
					break;

					case 'feedback':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							if ( $this->get('q'))
							{
								$query = $this->db
								->from('feedback')
								->like('pesan' , $this->get('q') , 'both')
								->order_by('tanggal_waktu DESC')
								->get();
							}
							else
							{
								$query = $this->db
								->from('feedback')
								->order_by('tanggal_waktu DESC')
								->get();
							}

							$row = $query->num_rows();

							if ( $row > 0)
							{
								$result = null;

								foreach($query->result() as $data)
								{
									$result[] = array(
											'id' => $data->id,
											'nama' => $data->nama,
											'pesan' => $data->pesan,
											'tanggal_waktu' => array(
													'timestamp' => strtotime($data->tanggal_waktu),
													'real_datetime' => $data->tanggal_waktu,
													'human_datetime' => humantime($data->tanggal_waktu)
												)
										);
								}
							}

							$response = array(
									'return' => $row > 0 ? true : false,
									$row > 0 ? 'data' : 'error_message' =>
									$row > 0 ? $result : 'Data not found!'
								);
						}
					break;

					case 'transaksi':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$getdata = $this->get();

							if ( ! $getdata['method'])
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgMethodNotAllowed
									);
							}
							else
							{
								// select * from transfer_pulsa Where month(tanggal_waktu) = MONTH(current_date());
								switch( $getdata['method'])
								{
									case 'transfer_pulsa':
										$query = null;

										if ( isset($getdata['sort']))
										{
											$x = explode(':' , $getdata['sort']);
											$x = str_replace(array('[',']'), '', $x);

											switch( trimLower($x[0]))
											{
												case 'no_hp':
													$query = $this->db->get_where('transfer_pulsa', array(
															'nomer_pengirim' => $x[1]
														));
												break;

												case 'user_id':
													$query = $this->db->get_where('transfer_pulsa', array(
															'id_user' => $x[1]
														));
												break;

												case 'detail':
													$query = $this->db->get_where('transfer_pulsa', array(
															'invoice' => $x[1]
														));
												break;

												case 'custom':
													$startEnd = explode('|', $x[1]);
													 // custom
													// SELECT * FROM table WHERE timestamp BETWEEN '2012-05-05 00:00:00' AND '2012-05	-05 23:59:59'

													if ( strpos($x[1], '|') == true)
													{
														$sql = "SELECT * FROM transfer_pulsa WHERE tanggal_waktu BETWEEN '".date('Y-m-d 00:00:00' , $startEnd[0])."' AND '".date('Y-m-d 23:59:59' , $startEnd[1])."'";
													}
													else
													{
														// query sengaja di null-kan karena parameter $x[1] tidak sesuai!
														$sql = "SELECT * FROM transfer_pulsa WHERE tanggal_waktu >= 'NULLABLE!'";
													}

													$query = $this->db->query($sql);
												break;

												case 'datetime':
													switch ($x[1]) {
														case 'today':
															// SELECT * FROM transfer_pulsa WHERE DATE(tanggal_waktu) = CURDATE()
															$sql = "SELECT * FROM transfer_pulsa WHERE DATE(tanggal_waktu) = CURDATE()";
															$query = $this->db->query($sql);
														break;

														case 'yesterday':
															// SELECT * FROM transfer_pulsa WHERE DATE(tanggal_waktu) = CURDATE() - 1
															$sql = "SELECT * FROM transfer_pulsa WHERE DATE(tanggal_waktu) = CURDATE() - 1";
															$query = $this->db->query($sql);
														break;

														case 'last7':
															// SELECT * FROM transfer_pulsa WHERE tanggal_waktu BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()
															$sql = "SELECT * FROM transfer_pulsa WHERE tanggal_waktu BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()";
															$query = $this->db->query($sql);
														break;

														case 'last30':
															// SELECT * FROM transfer_pulsa WHERE tanggal_waktu BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()
															$sql = "SELECT * FROM transfer_pulsa WHERE tanggal_waktu BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()";
															$query = $this->db->query($sql);
														break;

														case 'monthly':
															// select * from transfer_pulsa WHERE tanggaL_waktu >= '2017-09-01' AND tanggal_waktu < '2017-10-01'
															$sql = "SELECT * FROM transfer_pulsa WHERE tanggal_waktu >= '".date('Y-m-1')."' AND tanggal_waktu < '".date('Y-m-1',strtotime('+ 1 month'))."'";
															$query = $this->db->query($sql);
														break;

														case 'lastmonth':
															// SELECT * FROM table
															// WHERE YEAR(date_created) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
															// AND MONTH(date_created) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
															$sql = "SELECT * FROM transfer_pulsa";
															$sql.= " WHERE YEAR(tanggal_waktu) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)";
															$sql.= " AND MONTH(tanggal_waktu) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";

															$query = $this->db->query($sql);
														break;
													}
												break;
											}
										}
										else
										{
											$query = $this->db
												->from('transfer_pulsa')
												->order_by('tanggal_waktu DESC')
												->get();
										}

										$num = $query ? $query->num_rows() : null;

										$response = array(
												'return' => $num ? true : false,
												$query ? $num > 0 ? 
													'data' : 'message'
												: 'error_message' =>
												$query ? $num > 0 ? 
													$query->result() : 'Data masih kosong'
												: $this->msgMethodNotAllowed
											);
									break;

									default:
										$response = array(
												'return' => false,
												'error_message' => $this->msgMethodNotAllowed
											);
									break;
								}
							}
						}
					break;

					case 'user':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$getdata = $this->get();

							$query = null;

							if ( isset($getdata['token']))
							{
								// detail user
								$query = $this->db->get_where('user', array(
										'token' => trim($getdata['token'])
									));
							}
							else
							{
								$query = $this->db
									->from('user')
									->order_by('terdaftar DESC')
									->get();
							}

							$num = $query ? $query->num_rows() : false;

							$response = array(
									'return' => $num > 0 ? true : false,
									$num > 0 ? 'data' : 'error_message' => 
									$num > 0 ? $query->result() : 'Data user tidak ditemukan!'
								);
						}
					break;

					case 'download':
						if ( ! $auth )
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$getdata = $this->get();

							$data = null;

							if ( isset($getdata['url']))
							{
								$query = $this->db->get_where('app_info' , array(
										'key' => 'url-'. (int) $getdata['url']
									));

								foreach($query->result() as $row)
								{
									$data[] = array(
											'title' => $row->name,
											'content' => $row->content,
											'last_modified' => $row->last_modified
										);
								}
							}
							else
							{
								$this->db->like('key' , 'url-' , 'after');
								$query = $this->db->get('app_info');

								foreach($query->result() as $row)
								{
									$data[] = array(
											'title' => $row->name,
											'content' => $row->content,
											'last_modified' => $row->last_modified
										);
								}
							}

							$result = $data ? $data : null;

							$response = array(
									'return' => $result ? true : false,
									$result ? 'data' : 'error_message' => 
									$result ? $result : 'Data download url tidak ditemukan!'
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

	public function index_post($action = '' , $method = '')
	{
		$this->token = $this->post('auth');
		$this->role = 'authentication';
		$auth = authToken($this->role , $this->token);
		
		$postdata = array(
				'username' => $this->post('username'),
				'password' => $this->post('password'),
				'method' => $this->post('method'),
				'title' => $this->post('title'),
				'content' => $this->post('content'),
				'key' => $this->post('key'),
				'author' => $this->post('author'),
				'id_user' => $this->post('id_user'),
				'nomer_tujuan' => $this->post('nomer_tujuan'),
				'nomer_pengirim' => $this->post('nomer_pengirim'),
				'nominal' => $this->post('nominal'),
				'dilihat' => $this->post('dilihat')
			);

		switch( trimLower($action))
		{
			case 'public':
				switch( trimLower($method))
				{
					case 'kabar-burung':
						if ( ! $this->token)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgErrorToken
								);
						}
						elseif ( ! $auth)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						elseif ( ! $postdata['method'])
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						else
						{
							$listMethod = array('ubah','baru','hapus');

							if ( ! in_array($postdata['method'], $listMethod))
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgMethodNotAllowed
									);
							}
							else
							{
								switch( trimLower($postdata['method']))
								{
									case 'baru':
										if ( ! $postdata['title']
											|| ! $postdata['content'] || ! $postdata['author'])
										{
											$response = array(
													'return' => false,
													'error_message' => $this->msgFieldNull
												);
										}
										else
										{
											// $mimeAccepted = array('image/png','image/jpeg');
											// $extAccepted = array('jpg','png','jpeg');
											// $checkExt = explode('.' , $_FILES['gambar_utama']['name']);
											// $imageMime = checkMime($_FILES['gambar_utama']['name']);

											// if ( ! in_array($imageMime, $mimeAccepted))
											// {
											// 	$response = array(
											// 			'return' => false,
											// 			'error_message' => 'Maaf, Gambar utama hanya boleh berektensi JPG,JPEG atau PNG'
											// 		);
											// }
											$checkslug = $this->db->get_where('berita' , 
												array('slug' => createSlug($postdata['title'])));

											$rowslug = $checkslug->num_rows();

											if ( $rowslug > 0)
											{
												$response = array(
														'return' => false,
														'error_message' => 'Slug masih ada yang sama, harap ubah Judul'
													);
											}
											else
											{
												$destination = 'resources/uploads/';
												$today = date('Ymd');

												if ( ! is_dir(FCPATH.$destination.$today))
												{
													mkdir(FCPATH.$destination.$today);
												}

												$imageEncrypt = generate_image($_FILES['gambar_utama']['name']);
												$dirUpload = FCPATH.$destination.$today.'/'.$imageEncrypt;
												$urlUpload = base_url().$destination.$today.'/'.$imageEncrypt;

												move_uploaded_file($_FILES['gambar_utama']['tmp_name'], $dirUpload);

												$key = generate_key();
												$data = array(
														'judul' => $postdata['title'],
														'gambar' => $urlUpload,
														'content' => $postdata['content'],
														'author' => $postdata['author'],
														'slug' => createSlug($postdata['title']),
														'dilihat' => 0,
														'key' => $key,
														'tanggal_waktu' => date('Y-m-d H:i:s'),
														'terakhir_diubah' => date('Y-m-d H:i:s')
													);

												$this->db->insert('berita' , $data);

												$query = $this->db->get_where('berita',  array(
														'slug' => createSlug($postdata['title']),
														'key' => $key
													))->result()[0];

												$response = array(
														'return' => true,
														'message' => 'Berhasil menambahkan Kabar Burung',
														'data' => $query,
														'v' => $_FILES['gambar_utama'],
														'uploads' => array(
																'dir_upload' => $dirUpload,
																'url_upload' => $urlUpload,
															)
													);
											}
										}
									break;

									case 'ubah':
										if ( ! $postdata['key'])
										{
											$response = array(
													'return' => false,
													'error_message' => $this->msgFieldNull
												);
										}
										else
										{
											$checkkey = $this->db->get_where('berita' , 
													array('key' => createSlug($postdata['key'])));

											$databerita = $checkkey->result()[0];

											if ( $checkkey->num_rows() > 0 )
											{	
												if ( isset($_FILES['gambar_utama']))
												{
													$destination = 'resources/uploads/';
													$today = date('Ymd');

													if ( ! is_dir(FCPATH.$destination.$today))
													{
														mkdir(FCPATH.$destination.$today);
													}

													$imageEncrypt = generate_image($_FILES['gambar_utama']['name']);
													$dirUpload = FCPATH.$destination.$today.'/'.$imageEncrypt;
													$urlUpload = base_url().$destination.$today.'/'.$imageEncrypt;

													move_uploaded_file($_FILES['gambar_utama']['tmp_name'], $dirUpload);

													$p = preg_replace('#^https?://#', '', $databerita->gambar);
													$x = explode('/' , $p);
													$count = count($x);
													$realpath = null;

													foreach($x as $key => $value)
													{
														if ( $key == 0)
															continue;

														$realpath .= $value.($key == ($count - 1) ? null : '/');
													}

													unlink(FCPATH.$realpath);
												}

												$key = generate_key();
												$data = array(
														'judul' => $postdata['title'] ?
															$postdata['title'] : $databerita->judul,
														'gambar' => $_FILES['gambar_utama'] ? 
															$urlUpload : $databerita->gambar,
														'content' => $postdata['content'] ?
															$postdata['content'] : $databerita->content,
														'author' => $postdata['author'] ?
															$postdata['author'] : $databerita->author,
														'slug' => $postdata['title'] ? 
															createSlug($postdata['title']) : $databerita->judul,
														'dilihat' => $postdata['dilihat'] ? 
															(int) $postdata['dilihat'] : $databerita->dilihat,
														'key' => $key,
														'terakhir_diubah' => date('Y-m-d H:i:s')
													);
												$this->db->where( array('key' => $postdata['key']));
												$this->db->update('berita' , $data);

												$response = array(
														'return' => true,
														'message' => 'Berhasil mengubah Kabar Burung'
													);
											}
											else
											{
												$response = array(
														'return' => false,
														'error_message' => 'Berita tidak ditemukan!'
													);
											}
										}
									break;

									case 'hapus':
										if ( ! $postdata['key'])
										{
											$response = array(
													'return' => false,
													'error_message' => $this->msgFieldNull
												);
										}
										else
										{
											$query = $this->db->get_where('berita', array(
													'key' => $postdata['key']
												));

											$row = $query->num_rows();

											if ( $row > 0)
											{

												$p = preg_replace('#^https?://#', '', $query->result()[0]->gambar);
												$x = explode('/' , $p);
												$count = count($x);
												$realpath = null;

												foreach($x as $key => $value)
												{
													if ( $key == 0)
														continue;

													$realpath .= $value.($key == ($count - 1) ? null : '/');
												}

												unlink(FCPATH.$realpath);

												$this->db->delete('berita' , array('key' => $postdata['key']));

												$response = array(
														'return' => true,
														'message' => 'Kabar Burung berhasil dihapus!'
													);
											}
											else
											{
												$response = array(
														'return' => false,
														'error_message' => 'Kabar Burung tidak ditemukan!'
													);
											}
										}
									break;
								}
							}
						}	
					break;

					case 'about':
						if ( ! $this->token)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						elseif ( ! $auth)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						elseif ( ! $postdata['method'])
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						else
						{
							$listMethod = array('update');

							if ( ! in_array($postdata['method'], $listMethod))
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgMethodNotAllowed
									);
							}
							else
							{
								switch($postdata['method'])
								{
									case 'update':
										$data = $this->db->get_where('app_info' , array('key' => 'about'))->result()[0];

										$title = ( $postdata['title']) ? trim($postdata['title']) : $data->name;
										$content = ( $postdata['content']) ? 
												trim(nl2br($postdata['content'])) : $data->content;

										$dataUpdate = array(
												'name' => $title,
												'content' => $content,
												'last_modified' => date('Y-m-d H:i:s')
											);

										$this->db->set($dataUpdate);
										$this->db->where( array('key' => 'about'));
										$this->db->update('app_info');

										$response = array(
												'return' => true,
												'message' => 'Berhasil mengubah data!',
											);
									break;
								}
							}
						}
					break;

					case 'disclaimer':
						if ( ! $this->token)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						elseif ( ! $auth)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						elseif ( ! $postdata['method'])
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						else
						{
							$listMethod = array('update');

							if ( ! in_array($postdata['method'], $listMethod))
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgMethodNotAllowed
									);
							}
							else
							{
								switch($postdata['method'])
								{
									case 'update':
										$data = $this->db->get_where('app_info' , array('key' => 'disclaimer'))->result()[0];

										$title = ( $postdata['title']) ? trim($postdata['title']) : $data->name;
										$content = ( $postdata['content']) ? 
												trim(nl2br($postdata['content'])) : $data->content;

										$dataUpdate = array(
												'name' => $title,
												'content' => $content,
												'last_modified' => date('Y-m-d H:i:s')
											);

										$this->db->set($dataUpdate);
										$this->db->where( array('key' => 'disclaimer'));
										$this->db->update('app_info');

										$response = array(
												'return' => true,
												'message' => 'Berhasil mengubah data!',
											);
									break;
								}
							}
						}
					break;

					case 'privacy':
						if ( ! $this->token)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						elseif ( ! $auth)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						elseif ( ! $postdata['method'])
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						else
						{
							$listMethod = array('update');

							if ( ! in_array($postdata['method'], $listMethod))
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgMethodNotAllowed
									);
							}
							else
							{
								switch($postdata['method'])
								{
									case 'update':
										$data = $this->db->get_where('app_info' , array('key' => 'privacy'))->result()[0];

										$title = ( $postdata['title']) ? trim($postdata['title']) : $data->name;
										$content = ( $postdata['content']) ? 
												trim(nl2br($postdata['content'])) : $data->content;

										$dataUpdate = array(
												'name' => $title,
												'content' => $content,
												'last_modified' => date('Y-m-d H:i:s')
											);

										$this->db->set($dataUpdate);
										$this->db->where( array('key' => 'privacy'));
										$this->db->update('app_info');

										$response = array(
												'return' => true,
												'message' => 'Berhasil mengubah data!',
											);
									break;
								}
							}
						}
					break;

					case 'transaksi':
						if ( ! $this->token)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						elseif ( ! $auth)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						elseif ( ! $postdata['method'])
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						else
						{
							switch( trimLower($postdata['method']))
							{
								case 'transfer_pulsa':
									if ( ! $postdata['nomer_pengirim'] || ! $postdata['nomer_tujuan']
											|| ! $postdata['nominal'])
									{
										$response = array(
												'return' => false,
												'error_message' => $this->msgFieldNull
											);
									}
									else
									{
										// status { 0 => pending , 1 => sukses }
										$dataInsert = array(
												'invoice' => createInvoice(),
												'id_user' => $postdata['id_user'] ? 
													$postdata['id_user'] : 0,
												'nomer_pengirim' => $postdata['nomer_pengirim'],
												'nomer_tujuan' => $postdata['nomer_tujuan'],
												'nominal' => $postdata['nominal'],
												'status' => $postdata['status'] ? $postdata['status'] : 0, 
												'tanggal_waktu' => date('Y-m-d H:i:s')
											);

										$this->db->insert('transfer_pulsa' , $dataInsert);

										$response = array(
												'return' => true,
												'message' => 'Berhasil menambah data!'
											);
									}
								break;

								default:
									$response = array(
											'return' => false,
											'error_message' => $this->msgMethodNotAllowed
										);
								break;
							}
						}
					break;

					case 'download':
						if ( ! $this->token)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						elseif ( ! $auth)
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgNotAuthorized
								);
						}
						else
						{
							$postdata = $this->post();

							if ( ! $postdata['link_1'] || ! $postdata['link_2']
									|| ! $postdata['link_3'])
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgFieldNull
									);
							}
							else
							{
								$this->db->like('key' , 'url-' , 'after');
								$appInfo = $this->db->get('app_info');

								$no = 1;
								foreach($appInfo->result() as $row)
								{
									$data = array(
											'content' => $postdata['link_'.$no++],
											'last_modified' => date('Y-m-d H:i:s')
										);

									$this->db->where( array('key' => $row->key));
									$this->db->update('app_info' , $data);
								}

								$response = array(
										'return' => true,
										'message' => 'Berhasil update download url'
									);
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
			break;

			case 'admin':
				switch( trimLower($method))
				{
					case 'login':
						if ( ! $postdata['username'] || ! $postdata['password'])
						{
							$response = array(
									'return' => false,
									'error_message' => $this->msgFieldNull
								);
						}
						else
						{
							$query = $this->db->get_where('administrator' , array(
									'username' => $postdata['username'],
									'password' => md5($postdata['password'])
								));

							$num = $query->num_rows();

							if ( $num > 0)
							{
								foreach($query->result() as $row)
								{
									$result = array(
											'nama' => $row->nama,
											'username' => $row->username,
											'foto_profil' => $row->foto_profil,
											'token' => $row->token
										);
								}
							}

							$response = array(
									'return' => $num > 0 ? true : false,
									$num > 0 ? 'data' : 'error_message' => 
									$num > 0 ? $result : 'Username atau Password salah!'
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