<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musers extends CI_Model {

	public function getall($limit = 20, $offset = 0, $type = 'result')
	{
		$this->db->select('users.*, users_groups.group_id, groups.description AS group_name');

		$this->db->join('users_groups', 'users.id = users_groups.user_id', 'left');

		$this->db->join('groups', 'users_groups.group_id = groups.id', 'left');

		if( $this->input->get('query') != '')
			$this->db->like('users.name', $this->input->get('query'));

		$this->db->order_by('users.id', 'desc');

		$this->db->group_by('users.id');

		if( $type == 'num' )
		{
			return $this->db->get('users')->num_rows();
		} else {
			return $this->db->get('users', $limit, $offset)->result();
		}
	}

	public function get($param = 0)
	{
		$this->db->select('users.*, users_groups.group_id, groups.description AS group_name');

		$this->db->join('users_groups', 'users.id = users_groups.user_id', 'left');

		$this->db->join('groups', 'users_groups.group_id = groups.id', 'left');

		$this->db->where('users.id', $param);

		$this->db->order_by('users.id', 'desc');

		$this->db->group_by('users.id');

		return $this->db->get('users')->row();
	}

	public function create()
	{
		$data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
		);

		$this->ion_auth->register(
			$this->input->post('email'), 
			password_hash($this->input->post('password'), PASSWORD_DEFAULT), 
			$this->input->post('email'), 
			$data, 
			array('2')
		);

		$memberID = $this->db->get_where('users', array('email' => $this->input->post('email')))->row('id');

		if($this->db->affected_rows())
		{
			$this->template->notif(
				' Data pengguna berhasil ditambahkan.', 
				array('type' => 'success','icon' => 'check')
			);
		} else {
			$this->template->notif(
				' Gagal saat menyimpan data.', 
				array('type' => 'warning','icon' => 'warning')
			);
		}

		return $memberID;
	}

	public function update($param = 0)
	{
		$data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
		);

		$this->db->update( 'users', $data, array('id' => $param));

		$this->db->update('users_groups', array(
			'group_id' => $this->input->post('group')
		), array(
			'user_id' => $param
		));

		if($this->db->affected_rows())
		{
			$this->template->notif(
				' Perubahan berhasil disimpan.', 
				array('type' => 'success','icon' => 'check')
			);
		} else {
			$this->template->notif(
				' Tidak ada data yang diubah.', 
				array('type' => 'warning','icon' => 'warning')
			);
		}
	}

	public function updateAccount($param = 0)
	{
		$data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
		);

		$this->db->update( 'users', $data, array('id' => $param));

		if($this->db->affected_rows())
		{
			$this->template->notif(
				' Perubahan berhasil disimpan.', 
				array('type' => 'success','icon' => 'check')
			);
		} else {
			$this->template->notif(
				' Tidak ada data yang diubah.', 
				array('type' => 'warning','icon' => 'warning')
			);
		}
	}

	public function delete($param = 0)
	{
		$this->db->delete('users', array('id' => $param));
		$this->db->delete('users_groups', array('user_id' => $param));

		$this->template->notif(
			' Data berhasil dihapus.', 
			array('type' => 'success','icon' => 'check')
		);
	}
}

/* End of file Musers.php */
/* Location: ./application/models/Musers.php */
