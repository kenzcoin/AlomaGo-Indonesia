<?php

if ( ! function_exists('endpoint_url'))
{
	function endpoint_url()
	{
		$uri = "http://localhost:3030";
		return $uri;
	}
}

if ( ! function_exists('resources_url'))
{
	function resources_url()
	{
		$uri = base_url().'resources/';
		return $uri;
	}
}

if ( ! function_exists('admin_url'))
{
	function admin_url()
	{
		$uri = base_url().'admin/';
		return $uri;
	}
}