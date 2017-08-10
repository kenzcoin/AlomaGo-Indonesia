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
						if ( ! $this->input->get('encrypted'))
						{
							redirect(admin_url());
						}
						else
						{
							$data['kabarburung'] = $this->EndpointInterface->getDetailKabarBurung(
													$this->authToken , $this->input->get('encrypted'));
							self::isTemplate('burung_edit' , $data);	
						}
					break;

					default:
						$data['subTitle'] = "Kabar Burung";
						$data['lists'] = $this->EndpointInterface->getKabarBurung($this->authToken);
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
				self::isTemplate('url' , $data);
			break;

			/* Report */

			case 'history':
				self::hasLogin();
				$data['subTitle'] = "History";
				self::isTemplate('history' , $data);
			break;

			case 'feedback':
				self::hasLogin();
				$data['subTitle'] = "Feedback";
				$data['feedback'] = $this->EndpointInterface->getFeedback($this->authToken);
				self::isTemplate('feedback' , $data);
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
}