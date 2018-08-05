<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_panel 
{
	public $data;

	public $per_page;

	public $page;

	public $query;

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('pagination'));

		$this->load->model(array('musers'));

		$this->per_page = (!$this->input->get('per_page')) ? 20 : $this->input->get('per_page');

		$this->page = $this->input->get('page');

		$this->query = $this->input->get('query');

		$this->load->js(base_url("assets/js_app/user.js"));
	}

	public function index()
	{
		$config = $this->template->pagination_list();

		$config['base_url'] = base_url("users?per_page={$this->per_page}&query={$this->query}");

		$config['per_page'] = $this->per_page;
		$config['total_rows'] = $this->musers->getall(null, null, 'num');

		$this->pagination->initialize($config);
		$data = array(
			'title' => 'User',
			'users' => $this->musers->getall($this->per_page, $this->page)
		);
		$this->template->view('setting/user_all', $data);
	}

	public function create()
	{
		$this->form_validation->set_rules('name', 'Nama lengkap', 'trim|required');
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required|is_unique[users.phone]');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('group', 'Akses Pengguna', 'trim|required');

		if( $this->form_validation->run() == TRUE )
		{
			$user = $this->musers->create();

			redirect(base_url("users/update/{$user}"));
		} 

		$this->data = array(
			'title' => "Tambah Data Pengguna Aplikasi"
		);

		$this->template->view('setting/user-create', $this->data);
	}

	public function update($param = 0)
	{
		$this->form_validation->set_rules('name', 'Nama lengkap', 'trim|required');
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('group', 'Akses Pengguna', 'trim|required');

		if( $this->form_validation->run() == TRUE )
		{
			$user = $this->musers->create();

			redirect(base_url("users/update/{$user}"));
		} 

		$this->data = array(
			'title' => "Ubah Data Pengguna Aplikasi",
			'user' => $this->musers->get($param)
		);

		$this->template->view('setting/user-update', $this->data);
	}

	public function delete($param = 0)
	{
		$this->musers->delete($param);

		redirect('users');
	}

	public function account()
	{
		$this->form_validation->set_rules('name', 'Nama lengkap', 'trim|required');
		$this->form_validation->set_rules('phone', 'Telepon', 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if( $this->form_validation->run() == TRUE )
		{
			$this->musers->updateAccount($this->account->id);

			redirect(base_url("users/account"));
		} 

		$this->data = array(
			'title' => "Pengaturan Akun"
		);

		$this->template->view('setting/change-akun', $this->data);
	}
}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */