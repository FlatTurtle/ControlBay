<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->model('Customer');
        $this->Customer->get_by_id(1);
	}
}
