<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mproduct extends CI_Model 
{
	/**
	 * Inisialisasi Global Method variable
	 **/
	private $method_terlaris = array();
	/**
	 * Menampilkan semua produk yang dibeli per transaksi
	 *
	 * @param Integer (ID_transaction)
	 * @return Array
	 **/
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('app');
		
		$this->load->library(array('template'));
	}

	public function getall($limit = 20, $offset = 0, $type = 'result')
	{
		$this->db->select('tb_product.*, tb_category_product.category');

		$this->db->join('tb_category_product', 'tb_product.category_product = tb_category_product.category_product', 'left');

		if( $this->input->get('query') != '')
			$this->db->like('product_name', $this->input->get('query'))
					->or_like('product_code', $this->input->get('query'));

		$this->db->order_by('ID', 'desc');

		if( $type == 'num' )
		{
			return $this->db->get('tb_product')->num_rows();
		} else {
			return $this->db->get('tb_product', $limit, $offset)->result();
		}
	}

	public function get($param = 0)
	{
		return $this->db->get_where('tb_product', array('ID' => $param))->row();
	}

	public function create()
	{
		$this->db->insert('tb_product', array(
			'product_code' => $this->input->post('code'),
			'product_name' => $this->input->post('name'),
			'product_unit' => $this->input->post('unit'),
			'category_product' => $this->input->post('category'),
			'purchase' => $this->input->post('purchase'),
			'stock' => $this->input->post('stock'),
			'default_price' => $this->input->post('default_price'),
			'reseller_price' => $this->input->post('reseller_price')
		));

		if($this->db->affected_rows())
		{
			$this->template->notif(
				' Produk berhasil ditambahkan.',  
				array('type' => 'success','icon' => 'check')
			);
		} else {
			$this->template->notif(
				' Gagal saat menyimpan data.', 
				array('type' => 'warning','icon' => 'warning')
			);
		}
	}

	public function update($param = 0)
	{
		$validate = $this->db->where_not_in('ID', $param)->where('product_code', $this->input->post('code'))->get('tb_product')->num_rows();

		if($validate == FALSE) 
		{
			$this->db->update('tb_product', array(
				'product_code' => $this->input->post('code'),
				'product_name' => $this->input->post('name'),
				'product_unit' => $this->input->post('unit'),
				'category_product' => $this->input->post('category'),
				'purchase' => $this->input->post('purchase'),
				'stock' => $this->input->post('stock'),
				'default_price' => $this->input->post('default_price'),
				'reseller_price' => $this->input->post('reseller_price')
			), array(
				'ID' => $param
			));

			if($this->db->affected_rows())
			{
				$this->template->notif(
					' Produk berhasil ditambahkan.',  
					array('type' => 'success','icon' => 'check')
				);
			} else {
				$this->template->notif(
					' Gagal saat menyimpan data.', 
					array('type' => 'warning','icon' => 'warning')
				);
			}
		} else {
			$this->template->notif(
				' Kode produk sama dengan produk lainnya.', 
				array('type' => 'warning','icon' => 'warning')
			);
		}
	}

	public function get_product_trans( $ID = 0)
	{
		$query = $this->db->query("SELECT tb_detail_transaction.*, tb_product.* FROM tb_detail_transaction LEFT JOIN tb_product ON tb_product.ID_product = tb_detail_transaction.ID_product WHERE tb_detail_transaction.ID_transaction = '{$ID}'")->result();
		return $query;
	}
	/**
	 * Menghitung jumlah produk per transaksi 
	 *
	 * @param Integer (ID_transaction)
	 * @return Integer
	 **/
	public function count_product_trans( $ID=0)
	{
		$query = $this->db->query("SELECT * FROM tb_detail_transaction WHERE ID_transaction = '{$ID}'")->num_rows();
		return $query;
	}
	/**
	 * Menghiting subtotal transaksi per produk
	 *
	 * @param Integer (ID_transaction)
	 * @return Integer
	 **/
	public function subtot_product_trans( $ID = 0)
	{
		$jumlah_barang = count($this->count_product_trans($ID));
		$subtotal = 0;
		foreach ($this->get_product_trans($ID) as $row) :
			$subtotal += $this->harga->get($row->ID_category, $row->ID_product) * $row->quantity;
		endforeach;
		return $subtotal;
	}
	/**
	 * Menghitung produk terlaris
	 *
	 * @param String (Array => Assoc), Integer (ID_category)
	 * @return Integer
	 **/
	public function terlaris($method_terlaris, $ID)
	{
		$query = $this->db->query("SELECT * FROM tb_transaction LEFT JOIN tb_detail_transaction ON tb_transaction.ID_transaction = tb_detail_transaction.ID_transaction WHERE tb_transaction.date BETWEEN '{$method_terlaris['from']}' AND '{$method_terlaris['to']}' AND tb_detail_transaction.ID_product = '{$method_terlaris['id']}' AND tb_detail_transaction.ID_category LIKE '%{$ID}%'");
		$total = 0;
		foreach ($query->result() as $row) :
			$total += $row->quantity; 
		endforeach;
		return $total;
	}
	/**
	 * Menampilkan Stok Limit pada halaman dashboard
	 *
	 * @return Array
	 **/
	public function stock_dashboard()
	{

		$query = $this->db->query("SELECT tb_product.*, tb_product_stock.*, tb_category_product.* FROM tb_product LEFT JOIN tb_product_stock ON tb_product.ID_product=tb_product_stock.ID_product LEFT JOIN tb_category_product ON tb_product.category_product = tb_category_product.category_product WHERE tb_product_stock.stock BETWEEN '0' AND '10' ORDER BY tb_product_stock.stock ASC");
		return $query->result();
	}
}

/* End of file Mproduct.php */
/* Location: ./application/models/Mproduct.php */