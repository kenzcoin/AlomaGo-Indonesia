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
							if ( ! $this->input->get('method'))
							{
								$response = array(
										'return' => false,
										'error_message' => $this->msgErrorParameter
									);
							}
							else
							{
								switch( trimLower($this->input->get('method')))
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
										if ( ! $this->input->get('key'))
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
											->where( array('key' => $this->input->get('key')))
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

									case 'top':
										$limit = $this->input->get('limit') ?
										$this->input->get('limit') : 5;

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
									'return' => true,
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
									'return' => true,
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
									'return' => true,
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
							$query = $this->db
							->from('feedback')
							->order_by('tanggal_waktu DESC')
							->get();

							$row = $query->num_rows();

							if ( $row > 0)
							{
								$result = null;

								foreach($query->result() as $data)
								{
									$result[] = array(
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
									'return' => true,
									$row > 0 ? 'data' : 'error_message' =>
									$row > 0 ? $result : 'Data not found!'
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
				'content' => $this->post('content')
			);

		switch( trimLower($action))
		{
			case 'public':
				switch( trimLower($method))
				{
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