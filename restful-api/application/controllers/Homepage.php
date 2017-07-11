<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Homepage extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index_get()
	{
		return $this->response(array(
				'return' => false,
				'error_message' => "Parameter tidak ditemukan!"
			));
	}

}

/* End of file Homepage.php */
/* Location: ./application/controllers/Homepage.php */