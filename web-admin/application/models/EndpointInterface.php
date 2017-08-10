<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EndpointInterface extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->endpointUri = endpoint_url();
	}

	/* @GET Kabar Burung */
	public function getKabarBurung($token)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=list&auth='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET Detail Kabar Burung */
	public function getDetailKabarBurung($token , $key)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=detail&key='.$key.'&auth='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET Top Kabar Burung */
	public function getTopKabarBurung($token , $limit = null)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=top';

		if ( $limit )
		{
			$this->uri .= "&limit=".$limit;
		}

		$this->uri .= "&auth=".$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @GET About */
	public function getAbout($token)
	{
		$this->uri = $this->endpointUri.'/public/about?auth='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST About */
	public function postAbout($data)
	{
		$this->uri = $this->endpointUri.'/public/about';

		$endpoint = $this->curl->simple_post($this->uri, $data);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @GET Privacy Policy */
	public function getPrivacy($token)
	{
		$this->uri = $this->endpointUri.'/public/privacy?auth='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST Privacy */
	public function postPrivacy($data)
	{
		$this->uri = $this->endpointUri.'/public/privacy';

		$endpoint = $this->curl->simple_post($this->uri, $data);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @GET Disclaimer */
	public function getDisclaimer($token)
	{
		$this->uri = $this->endpointUri.'/public/disclaimer?auth='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST Disclaimer */
	public function postDisclaimer($data)
	{
		$this->uri = $this->endpointUri.'/public/disclaimer';

		$endpoint = $this->curl->simple_post($this->uri, $data);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET Feedback */
	public function getFeedback($token)
	{
		$this->uri = $this->endpointUri.'/public/feedback?auth='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST Login Admin */
	public function postLogin($data)
	{
		$this->uri = $this->endpointUri.'/admin/login';

		$endpoint = $this->curl->simple_post($this->uri, $data);
		$result = json_decode($endpoint);

		return $result;
	}
}

/* End of file EndpointInterface.php */
/* Location: ./application/models/EndpointInterface.php */