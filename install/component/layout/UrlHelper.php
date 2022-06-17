<?php
	
	
	function baseUrl()
	{
		if (isset($_SERVER['HTTPS'])) {
			$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		} else {
			$protocol = 'http';
		}
		return $protocol . "://" . $_SERVER['HTTP_HOST'] . str_replace("install/", "", $_SERVER['REQUEST_URI']);
	}