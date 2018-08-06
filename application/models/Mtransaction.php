<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtransaction extends CI_Model 
{
	public function getall($limit = 20, $offset = 0, $type = 'result')
	{
		$this->db->select('tb_transaction.*, users.name, (SELECT SUM(price*quantity) FROM tb_detail_transaction WHERE ID_transaction = tb_transaction.ID_transaction ) AS total');

		$this->db->join('users', 'tb_transaction.user_id = users.id', 'left');

		if( $this->input->get('query') != '')
			$this->db->like('ID_transaction', $this->input->get('query'));

		if($this->input->get('from') != '')
			$this->db->where('DATE(date) >= ', $this->input->get('from'));

		if($this->input->get('to') != '')
			$this->db->where('DATE(date) <= ', $this->input->get('to'));

		if($this->input->get('kasir') != '')
			$this->db->where('tb_transaction.user_id', $this->input->get('kasir'));

		$this->db->order_by('date', 'desc');

		if( $type == 'num' )
		{
			return $this->db->get('tb_transaction')->num_rows();
		} else {
			return $this->db->get('tb_transaction', $limit, $offset)->result();
		}
	}

	public function getallByUser($from = NULL, $to = NULL, $kasir = 0, $type = 'result')
	{
		$this->db->select('tb_transaction.*, users.name, (SELECT SUM(price*quantity) FROM tb_detail_transaction WHERE ID_transaction = tb_transaction.ID_transaction ) AS total');

		$this->db->join('users', 'tb_transaction.user_id = users.id', 'left');

		$this->db->where('DATE(date) >= ', $from);

		$this->db->where('DATE(date) <= ', $to);

		$this->db->where('tb_transaction.user_id', $kasir);

		$this->db->order_by('date', 'desc');

		if( $type == 'num' )
		{
			return $this->db->get('tb_transaction')->num_rows();
		} else {
			return $this->db->get('tb_transaction')->result();
		}
	}

	public function get($param = 0)
	{
		$this->db->where('ID_transaction', $param);

		return $this->db->get('tb_transaction')->row();
	}

	public function getItemByCode($param = 0)
	{
		$this->db->select('tb_detail_transaction.*, tb_product.product_name, tb_product.stock, tb_product.product_code, tb_product.product_unit');

		$this->db->join('tb_product', 'tb_detail_transaction.product = tb_product.ID', 'left');

		$this->db->where('tb_product.product_code', $param);

		return $this->db->get('tb_detail_transaction')->row();
	}

	public function getItemById($param = 0)
	{
		$this->db->select('tb_detail_transaction.*, tb_product.product_name, tb_product.stock, tb_product.product_code, tb_product.product_unit');

		$this->db->join('tb_product', 'tb_detail_transaction.product = tb_product.ID', 'left');

		$this->db->where('tb_product.ID', $param);

		return $this->db->get('tb_detail_transaction')->row();
	}

	public function getProductItems($param = 0)
	{
		$this->db->select('tb_detail_transaction.*, tb_product.product_name, tb_product.product_unit, tb_product.product_code, ');

		$this->db->join('tb_product', 'tb_detail_transaction.product = tb_product.ID', 'left');

		$this->db->where('tb_detail_transaction.ID_transaction', $param);

		return $this->db->get('tb_detail_transaction')->result();
	}

	/**
	 * Inisialisasi Global Method variable atau konstanta
	 **/

	/**
	 * Menampilkan Profit penjualan
	 *
	 * @param String (date) 
	 * @return Integer
	 **/
	public function profit( $date = NULL)
	{
		if($date == NULL) {
			$date = date('Y-m-d'); 
		}

		$this->db->select('(SELECT SUM(price*quantity) FROM tb_detail_transaction WHERE ID_transaction = tb_transaction.ID_transaction ) AS total');

		$this->db->join('users', 'tb_transaction.user_id = users.id', 'left');

		$this->db->where('DATE(date)', $date);

		$total = 0;
		foreach ($this->db->get('tb_transaction')->result() as $key => $value) 
			$total += $value->total;

		return $total;
	}
	/**
	 * Menampilkan Jumlah transaksi by date
	 *
	 * @param Strig (date)
	 * @return Integer
	 **/
	public function count($date = NULL)
	{
		if(!$date) : $date = date('Y-m-d'); endif;
		$query = $this->db->query("SELECT DATE(date) FROM tb_transaction WHERE DATE(date) = '{$date}'");
		return $query->num_rows();
	}
}

/* End of file Mtransaction.php */
/* Location: ./application/models/Mtransaction.php */