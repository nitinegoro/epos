<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('session'));
	}
}

/**
* Extends Class Admin_panel
*
* @author Vicky Nitinegoro <pkpvicky@gmail.com>
*/
class Admin_panel extends CI_Controller
{
	public $account;

	public function __construct()
	{
		parent::__construct();

		$this->load->library(
			array('session','template','breadcrumbs','page_title', 'pagination','form_validation','ion_auth')
		);

		$this->load->helper(
			array('text', 'form', 'language','date')
		);

		if(!$this->ion_auth->logged_in())  
		{
			redirect('auth');
		} else {
			$this->account = $this->ion_auth->user()->row();
		}

		$this->breadcrumbs->unshift(0, 'Dashboard', "administrator");

		//$this->load->js(base_url("public/backend/app/dialog.js"));
		//$this->load->js(base_url("public/backend/app/editor.js"));
	}
}



/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */