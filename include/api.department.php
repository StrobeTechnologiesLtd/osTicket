<?php

include_once INCLUDE_DIR.'class.api.php';
include_once INCLUDE_DIR.'class.dept.php';

class DepartmentApiController extends ApiController {
	function getRequest($format)
	{
		// The parent class defines stuff to pass data in the _body_ of the request
		// and allows for various formats json/xml/email
		// We are less clever and just want to process GET/POST data in the traditional way
		// so if there is a format specified, pass this up to the parent to fetch the request
		// data, otherwise we are just going to use the traditional $_GET/$_POST arrays which
		// host the request data
		if ($format)
			return parent::getRequest($format);

		if ($_SERVER['REQUEST_METHOD'] == "POST")
			return $_POST;
		else
			return $_GET;
	}
    function listDepartments()
    {
        if(!($key=$this->requireApiKey()))
            return $this->exerr(401, __('API key not authorized'));
        $deps = Dept::getPublicDepartments();
        $this->response(200, json_encode($deps));
    }
}