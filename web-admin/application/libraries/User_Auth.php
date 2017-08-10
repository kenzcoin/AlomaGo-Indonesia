<?php

class User_Auth {

	protected $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
		$this->endpointUri = "http://localhost:8080";
	}

	function loginAuth()
	{
		$instance = $this->_ci;
		if ( $instance->session->userdata('adminAuth'))
		{
			return true;
		}

		return false;
	}
}