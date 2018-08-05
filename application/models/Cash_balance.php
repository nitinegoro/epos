<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_balance extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getByDate($date = NULL, $mutation = NULL)
	{
		$this->db->where('DATE(date)', $date);

		$this->db->where('mutation', $mutation);

		return $this->db->get('cash_balance')->result();
	}

	public function getRangeDate($start = NULL, $end = NULL)
	{
		$this->db->where('DATE(date) >= ', $start);

		$this->db->where('DATE(date) <= ', $end);

		return $this->db->get('cash_balance')->result();
	}
	
	public function delete($param = 0)
	{
		$this->db->delete('cash_balance', array('ID' => $param));

		if($this->db->affected_rows())
		{
			$data = array(
				'status' => 'success',
				'message' => "Data berhasil dihapus"
			);
		} else {
			$data = array(
				'status' => 'failed',
				'message' => "Gagal saat menghapus data."
			);
		}

		return $data;
	}

}

/* End of file Cash_balance.php */
/* Location: ./application/models/Cash_balance.php */