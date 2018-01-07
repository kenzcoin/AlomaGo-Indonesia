<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->siteTitle = "Admin Aloma Go";
		$this->authToken = "7ce523c2d1-b0TqG-5312032051";
		$this->admin_data = $this->session->userdata('adminData');
	}

	private function isTemplate($content, $data = null)
	{
		$data['site_title'] = $this->siteTitle;
		$this->load->view('templates/header',$data);
		$this->load->view($content,$data);
		$this->load->view('templates/footer',$data);
	}

	private function hasLogin()
	{
		if ( $this->user_auth->loginAuth())
		{
			return $this->user_auth->loginAuth();
		}
		else
		{
			redirect(admin_url().'login');
		}
	}

	private function indexView()
	{
		self::hasLogin();
		$data['subTitle'] = "Dashboard";
		$data['topLists'] = $this->EndpointInterface->getTopKabarBurung($this->authToken);
		$data['dataFeedback'] = $this->EndpointInterface->getFeedback($this->authToken);
		$data['transferPulsa'] = $this->EndpointInterface->getTransferPulsa($this->authToken);
		$data['dataUser'] = $this->EndpointInterface->getUser($this->authToken);
		$data['historyMonthly'] = $this->EndpointInterface->getTransferPulsa($this->authToken,'[datetime:monthly]');

		self::isTemplate('dashboard' , $data);
	}

	public function index()
	{
		self::indexView();
	}

	public function halaman($view)
	{
		$method = $this->input->get('method');

		switch( trimLower($view))
		{
			case 'beranda':
				self::hasLogin();
				self::indexView();
			break;

			/* Kabar Burung */

			case 'kabar-burung':
				self::hasLogin();
				switch( trimLower($method))
				{
					case 'new':
						self::isTemplate('burung_new');
					break;

					case 'edit':
						if ( ! $this->input->get('token'))
						{
							redirect(admin_url());
						}
						else
						{
							$data['kabarburung'] = $this->EndpointInterface->getDetailKabarBurung(
													$this->authToken , $this->input->get('token'));
							self::isTemplate('burung_edit' , $data);	
						}
					break;

					case 'hapus':
						$getdata = $this->input->get();
						if ( ! $getdata['token'])
						{
							redirect(admin_url());
						}
							
						$data = array(
								'auth' => $this->authToken,
								'method' => 'hapus',
								'key' => $getdata['token']
							);

						$this->EndpointInterface->postKabarBurung($data);

						redirect(admin_url().'kabar-burung');
					break;

					default:
						$getdata = $this->input->get();
						$data['subTitle'] = "Kabar Burung";
						$data['lists'] = trim(isset($getdata['q'])) ?
							$this->EndpointInterface->getSearchKabarBurung($this->authToken, trim($getdata['q']))
							: $this->EndpointInterface->getKabarBurung($this->authToken);
						self::isTemplate('burung' , $data);
					break;
				}
			break;

			/* App Info */

			case 'disclaimer':
				self::hasLogin();
				$data['subTitle'] = "Disclaimer";
				$data['disclaimer'] = $this->EndpointInterface->getDisclaimer($this->authToken);
				self::isTemplate('disclaimer' , $data);
			break;

			case 'privacy':
				self::hasLogin();
				$data['subTitle'] = "Privacy Policy";
				$data['privacy'] = $this->EndpointInterface->getPrivacy($this->authToken);
				self::isTemplate('privacy' , $data);
			break;

			case 'about':
				self::hasLogin();
				$data['subTitle'] = "About";
				$data['about'] = $this->EndpointInterface->getAbout($this->authToken);
				self::isTemplate('about' , $data);
			break;

			case 'download-url':
				self::hasLogin();
				$data['subTitle'] = "Download URL";
				$data['dataUrl'] = $this->EndpointInterface->getDownloadUrl($this->authToken);
				self::isTemplate('url' , $data);
			break;

			/* Report */

			case 'history':
				$getdata = $this->input->get();
				$listGet = array('custom','today','yesterday','last7','last30','monthly','lastmonth');
				self::hasLogin();
				$data['subTitle'] = "History";
				if ( isset($getdata['list']))
				{
					if ( ! in_array($getdata['list'], $listGet))
					{
						show_404();
					}
					else
					{
						if ( $getdata['list'] == 'custom')
						{
							self::isTemplate('history_custom' , $data);
						}
						else
						{
							$arrayList = array(
								'today' => 'hari ini',
								'yesterday' => 'kemarin',
								'last7' => '7 hari terakhir',
								'last30' => '30 hari terakhir',
								'monthly' => 'bulan ini',
								'lastmonth' => 'bulan terakhir'
							);
							
							$data['list'] = $arrayList[trimLower($getdata['list'])];
							$sort = "[datetime:".trimLower($getdata['list'])."]";
							$data['transfer_pulsa'] = $this->EndpointInterface->getTransferPulsa($this->authToken, $sort);
							self::isTemplate('history' , $data);
						}
					}
				}
				else
				{
					$data['transfer_pulsa'] = $this->EndpointInterface->getTransferPulsa($this->authToken);
					self::isTemplate('history' , $data);
				}
			break;

			case 'feedback':
				$getdata = $this->input->get();
				self::hasLogin();
				$data['subTitle'] = "Feedback";
				$data['feedback'] = trim(isset($getdata['q'])) ? 
					$this->EndpointInterface->getFeedback($this->authToken , trim($getdata['q']))
					: $this->EndpointInterface->getFeedback($this->authToken);
				self::isTemplate('feedback' , $data);
			break;

			case 'test':
				// today
				echo date('Y-m-d H:i:s' , strtotime("today")).'<BR>';
				// yesterday
				echo date('Y-m-d H:i:s' , strtotime("-1 day")).'<BR>';
				// last7
				echo date('Y-m-d H:i:s' , strtotime("-7 day")).'<BR>';
				// last30
				echo date('Y-m-d H:i:s' , strtotime("-30 day")).'<BR>';
				// thismonth
				echo date("Y-m-d H:i:s", strtotime("first day of this month")).'<BR>';
				echo date("Y-m-d H:i:s", strtotime("last day of this month")).'<BR>';
				// lastmonth
				echo date("Y-m-d H:i:s", strtotime("first day of previous month")).'<BR>';
				echo date("Y-m-d H:i:s", strtotime("last day of previous month")).'<BR>';
			break;

			/* Action */

			case 'login':
				$this->load->view('action/login');
			break;

			case 'do_action':
				$method = trimLower($_REQUEST['method']);

				$postdata = array(
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'title' => $this->input->post('title'),
						'content' => $this->input->post('content')
					);

				if ( ! $method)
				{
					show_404();
				}
				else
				{
					switch($method)
					{
						case 'login':
							if ( ! $this->input->post())
							{
								redirect(admin_url().'login');
							}

							$data = array(
									'username' => $postdata['username'],
									'password' => $postdata['password']
								);

							$result = $this->EndpointInterface->postLogin($data);
							
							if ( $result->return )
							{
								$session_data = array(
										'adminAuth' => TRUE,
										'adminData' => $result->data 
									);
								$this->session->set_userdata($session_data);

								redirect(admin_url().'beranda');
							}
							else
							{
								redirect(admin_url().'login');
							}
						break;

						case 'about';
							self::hasLogin();
							if ( ! $this->input->post())
							{
								redirect(admin_url().'beranda');
							}

							$data = array(
									'auth' => $this->authToken,
									'method' => 'update',
									'title' => $postdata['title'],
									'content' => $postdata['content']
								);

							$result = $this->EndpointInterface->postAbout($data);

							redirect(admin_url().'about');
						break;

						case 'disclaimer':
							self::hasLogin();
							if ( ! $this->input->post())
							{
								redirect(admin_url().'beranda');
							}

							$data = array(
									'auth' => $this->authToken,
									'method' => 'update',
									'title' => $postdata['title'],
									'content' => $postdata['content']
								);

							$result = $this->EndpointInterface->postDisclaimer($data);

							redirect(admin_url().'disclaimer');
						break;

						case 'privacy':
							self::hasLogin();
							if ( ! $this->input->post())
							{
								redirect(admin_url().'beranda');
							}

							$data = array(
									'auth' => $this->authToken,
									'method' => 'update',
									'title' => $postdata['title'],
									'content' => $postdata['content']
								);

							$result = $this->EndpointInterface->postPrivacy($data);

							redirect(admin_url().'privacy');
						break;

						case 'new_kabarburung':
							if ( ! $this->input->post() || ! $_FILES)
							{
								// Gambar ERROR
								redirect(admin_url().'kabar-burung?method=new');
							}

							$data = array(
									'auth' => $this->authToken,
									'method' => 'baru',
									// 'gambar_utama' => $_FILES['gambar_utama'],
									'title' => $postdata['title'],
									'content' => nl2br($postdata['content']),
									'author' => $this->admin_data->nama
								);

							// print_r($data['gambar_utama']);

							$temp_upload = $this->temp_upload('gambar_utama'); 
                   			$dataImage = $temp_upload['data'];

                   			if ( ! $temp_upload['status'])
                   			{
                   				$this->session->set_userdata( array('uploadMsg' => 'Maaf, File gambar hanya boleh diupload berekstensi JPG, PNG atau JPEG'));
                   				redirect(admin_url().'kabar-burung?method=new');	
                   			}

							$rs = $this->EndpointInterface->postKabarBurungWithImage($dataImage,$data);

							if ( $rs->return)
							{
								unlink(FCPATH.'resources/uploads/'.$_FILES['gambar_utama']['name']);

								$this->session->set_userdata( array('uploadMsg' => 'Kabar Burung berhasil ditambakan'));
							}
							else
							{
								$this->session->set_userdata( array('uploadMsg' => $rs->error_message));
							}

							redirect(admin_url().'kabar-burung?method=new');	
						break;

						case 'edit_kabarburung':
							$postdata = $this->input->post();
							if ( ! $postdata)
							{
								// Gambar ERROR
								redirect(admin_url().'kabar-burung?method=new');
							}

							$data = array(
									'auth' => $this->authToken,
									'method' => 'ubah',
									'key' => $postdata['key'],
									'title' => $postdata['title'],
									'content' => nl2br($postdata['content']),
									'author' => $this->admin_data->nama
								);

							if ( $_FILES['gambarUtama']['size'] > 1 )
							{
								$temp_upload = $this->temp_upload('gambarUtama');
	                   			$dataImage = $temp_upload['data'];

	                   			if ( ! $temp_upload['status'])
	                   			{
	                   				$this->session->set_userdata( array('uploadMsg' => 'Maaf, File gambar hanya boleh diupload berekstensi JPG, PNG atau JPEG'));
	                   				redirect(admin_url().'kabar-burung?method=new');	
	                   			}

	                   			$rs = $this->EndpointInterface->postKabarBurungWithImage($dataImage,$data);
							}
							else
							{
								$rs = $this->EndpointInterface->postKabarBurungWithImage(null,$data);
							}

							if ( $rs->return)
							{
								if ( $_FILES['gambarUtama']['size'] > 0) 
								{
									unlink(FCPATH.'resources/uploads/'.$_FILES['gambarUtama']['name']);
								}

								$this->session->set_userdata( array('uploadMsg' => 'Kabar Burung berhasil diubah'));
							}
							else
							{
								$this->session->set_userdata( array('uploadMsg' => $rs->error_message));
							}
							
							redirect(admin_url().'kabar-burung');	
						break;

						case 'download-url':
							$postdata = $this->input->post();
							if ( ! $postdata)
							{
								redirect(admin_url().'download-url');
							}

							$data = array(
									'auth' => $this->authToken,
									'link_1' => $postdata['link1'],
									'link_2' => $postdata['link2'],
									'link_3' => $postdata['link3']
								);

							$this->EndpointInterface->postDownloadUrl($data);

							redirect(admin_url().'download-url');
						break;

						default:
							show_404();
						break;
					}
				}
			break;

			case 'logout':
				session_destroy();
				redirect(admin_url().'login');
			break;

			default:
				show_404();
			break;
		}
	}

	private function temp_upload($field_name) {
    	$config['upload_path'] = FCPATH.'resources/uploads/';
    	$config['allowed_types'] = 'jpeg|jpg|png';
    	$this->load->library('upload', $config);

    	if(!$this->upload->do_upload($field_name)) {
    		$status = 0;
    		$data = $this->upload->display_errors();
    	}
    	else {
    		$status = 1;
    		$data = $this->upload->data();
    	}
    	return array('status' => $status, 'data' => $data);
    }
}