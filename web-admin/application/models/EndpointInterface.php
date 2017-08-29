<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EndpointInterface extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->endpointUri = endpoint_url();
	}

	/* @GET Kabar Burung */
	public function getKabarBurung($auth)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=list&auth='.$auth;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @GET Kabar Burung */
	public function getSearchKabarBurung($auth, $q)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=search&q='.$q.'&auth='.$auth;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET Detail Kabar Burung */
	public function getDetailKabarBurung($auth , $key)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=detail&key='.$key.'&auth='.$auth;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST Kabar Burung */
	public function postKabarBurung($data)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung';

		$endpoint = $this->curl->simple_post($this->uri, $data);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET Top Kabar Burung */
	public function getTopKabarBurung($auth , $limit = null)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung?method=top';

		if ( $limit )
		{
			$this->uri .= "&limit=".$limit;
		}

		$this->uri .= "&auth=".$auth;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @GET About */
	public function getAbout($auth)
	{
		$this->uri = $this->endpointUri.'/public/about?auth='.$auth;

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
	public function getPrivacy($auth)
	{
		$this->uri = $this->endpointUri.'/public/privacy?auth='.$auth;

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
	public function getDisclaimer($auth)
	{
		$this->uri = $this->endpointUri.'/public/disclaimer?auth='.$auth;

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
	public function getFeedback($auth , $q = FALSE)
	{
		$this->uri = $this->endpointUri.'/public/feedback?auth='.$auth;

		if ( $q)
		{
			$this->uri .= '&q='.$q;
		}

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

	/* @$GET Transfer Pulsa */
	public function getTransferPulsa($auth , $sort = FALSE)
	{
		$this->uri = $this->endpointUri.'/public/transaksi?method=transfer_pulsa&auth='.$auth;

		if ( $sort)
		{
			$this->uri .= $sort;
		}

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET User */
	public function getUser($auth)
	{
		$this->uri = $this->endpointUri.'/public/user?auth='.$auth;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET User Detail */
	public function getUserDetail($auth , $token)
	{
		$this->uri = $this->endpointUri.'/public/user?auth='.$auth.'&token='.$token;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST Download Url */
	public function postDownloadUrl($data)
	{
		$this->uri = $this->endpointUri.'/public/download';

		$endpoint = $this->curl->simple_post($this->uri, $data);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @$GET Download Url */
	public function getDownloadUrl($auth)
	{
		$this->uri = $this->endpointUri.'/public/download?auth='.$auth;

		$endpoint = $this->curl->simple_get($this->uri);
		$result = json_decode($endpoint);

		return $result;
	}

	/* @POST Kabar Burung with Image */
	public function postKabarBurungWithImage($dataImage, $data)
	{
		$this->uri = $this->endpointUri.'/public/kabar-burung';

		//preping multipart header
		define('MULTIPART_BOUNDARY', '------'.microtime(true));
		$header = 'Content-Type: multipart/form-data; boundary='.MULTIPART_BOUNDARY;
	    $content = '';

	    if(!empty($dataImage)) {
	        $file_contents = file_get_contents($dataImage['full_path']);
	        //prepping image field
	        $content = "--".MULTIPART_BOUNDARY
	                    ."\r\n"
	                    ."Content-Disposition: form-data; name='gambar_utama'; filename='".$dataImage['orig_name']."'"
	                    ."\r\n"
	                    ."Content-type: ".$dataImage['file_type']
	                    ."\r\n\r\n"
	                    .$file_contents."\r\n";
	    }

		//prepping post field
		foreach ($data as $key => $value) {
			$content .= "--".MULTIPART_BOUNDARY."\r\n"
						."Content-Disposition: form-data; name='".$key."'"
						."\r\n\r\n"
						.$value."\r\n";
		}
		//signal end of request
		$content .= "--".MULTIPART_BOUNDARY."--\r\n";

		$context = stream_context_create(array(
				'http' => array(
						'method' => 'POST',
						'header' => $header,
						'content' => $content
					)
			));

		$result = file_get_contents($this->uri, false, $context);

		return json_decode($result);
	}
}

/* End of file EndpointInterface.php */
/* Location: ./application/models/EndpointInterface.php */