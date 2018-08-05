<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Login aplikasi
 * Aplikasi Management Toko Charlie
 * Index dari semua akses aplikasi.
 *
 * Enkripsi Login ini menggunakan password_hash
 * @return 
 * 		http://127.0.0.1/examplae_root/index.php/login
 *	- atau ( .htaccess ) -
 * 		http://127.0.0.1/examplae_root/login
 * @package login
 * @author https://www.facebook.com/muh.azzain
 * @see http://www.teitramega.com/
 **/
class Login extends CI_Controller {
	public function index()
	{
		$data = array('title' => 'Login Aplikasi'.DEFAULT_TITLE,  );
		$this->load->view('v_login', $data);
	}
	/**
	 * Handle Login Authentifikasi - Password_verify
	 *
	 * @param submited via ajax
	 * @return String ( Json Encode )
	 **/
	public function set_login()
	{	
		$row =  $this->get_username( $this->input->post('username') );
		if ( ! $row ) :
			$output = array(
				'status' => false, 
				'result' => array(
					'alert' => 'danger',
					'message' => 'User Tidak ditemukan !'
					) 
			);
		else :
			if ( password_verify( $this->input->post('password'), $row->user_password) ) :
	        	$data_session = array(
	        		'user_id' => $row->user_id,
	        		'user_name' => $row->user_name,
	        		'user_fullname' => $row->user_fullname,
	        		'user_type' => $row->user_type, 
	        	);
	        	$buat_session 	= $this->session->set_userdata('is_login', $data_session);
	        	$output = array(
	        		'status' => true, 
	        		'result' => array(
	        			'redirect' => site_url('main')
	        			)
	        	);
			else :
				$output = array(
					'status' => false, 
					'result' => array(
						'alert' => 'warning',
						'message' => 'Password tidak cocok !'
						) 
				);
			endif;
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	/**
	 * Handle Login Authentifikasi - md5
	 *
	 * @param submited via ajax
	 * @return String ( Json Encode )
	 **/
	public function auth_login()
	{
		$password = md5($this->input->post('password'));
		if(!$this->auth($this->input->post('username'), $password)) :
			$output = array(
				'status' => true, 
				'result' => array(
					'alert' => 'danger',
					'message' => 'Tidak Cocok!'
					) 
			);
		else :
			$row = $this->auth($this->input->post('username'), $password);
	        $data_session = array(
	        	'user_id' => $row->user_id,
	        	'user_name' => $row->user_name,
	        	'user_fullname' => $row->user_fullname,
	        	'user_type' => $row->user_type, 
	        );
	        $buat_session 	= $this->session->set_userdata('is_login', $data_session);
	        $output = array(
	        	'status' => true, 
	        	'result' => array(
	        		'redirect' => site_url('main')
	        		)
	        );
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	/**
	 * Mencocokkan data pada database untuk proses login
	 *
	 * @param String, String
	 * @return Row()
	 **/
	private function auth($username, $password)
	{
		$query = $this->db->query("SELECT * FROM tb_users WHERE user_name = '{$username}' AND user_password = '{$password}' AND user_status = 'Y'");
		if(!$query->num_rows()) :
			return false;
		else :
			return $query->row();
		endif;
	}
	/**
	 *  Mengambil data user berdasarkan username
	 *
	 * @param String
	 * @return Row()
	 **/
	private function get_username( $username = FALSE)
	{
		/**
		 * Mengambil data berdasarkan username
		 * @param String
		 * @return Result Query ->row();
		 **/
		if ( $username ) :
			$query = $this->db->query("SELECT user_id, user_fullname, user_password, user_type FROM tb_users WHERE user_status = 'Y'")->row();
			return $query;
		else :
			return false;
		endif;
	}
	public function log_out( )
	{
		/**
		 * Keluar dari aplikasi
		 **/
		$this->session->sess_destroy();
		redirect('login');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */