<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Laporan Produk aplikasi
 * Aplikasi Management Toko Charlie
 * Halaman Laporan Laporan Produk Penjualan.
 *
 * Controller ini berkaiitan dengan assets/js_app/app_report.js
 * @return 
 * 		http://127.0.0.1/examplae_root/index.php/data_product
 *	- atau ( .htaccess ) -
 * 		http://127.0.0.1/examplae_root/data_product
 * @package Laporam
 * @author https://www.facebook.com/muh.azzain
 * @see http://www.teitramega.com/
 **/
class Data_product extends CI_Controller {

	private $filtered = array();
	
	public function __construct( )
	{
		parent::__construct();
		if ( ! $this->session->userdata('is_login') ) :
			redirect('login');
			return;
		endif;
		$this->load->library(array('harga','pagination','custom'));
		$this->load->model(array('mproduct'));
	}
	public function index()
	{
		$filtered = array(
			'from' => (!$this->input->get_post('from')) ? '0000-00-00' : $this->input->get('from'),
			'to' => (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to'),
			'category' => (!$this->input->get('category')) ? false : $this->input->get('category'),
			'supplier' => (!$this->input->get('supplier')) ? false : $this->input->get_post('supplier'),
		);
		
		$page = ($this->input->get('page')) ? $this->input->get('page') : 0;

        $config = pagination_list();
        $config['base_url'] = site_url("data_product?from={$filtered['from']}&to={$filtered['to']}&category={$filtered['category']}&supplier={$filtered['supplier']}");
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $config['total_rows'] = $this->query_num($filtered);
        $this->pagination->initialize($config);

		$data = array(
			'title' => 'Laporan Produk Terlaris'.DEFAULT_TITLE, 
			'data_product' => $this->query_get($filtered, $config['per_page'], $page)
		);
		$this->template->view('laporan/v_dproduct', $data);	
	}
	private function filtered($filtered)
	{
		/**
		 * Query menampilkan produk (berkaittan dengan transaksi)
		 *
		 * @param Array (Assoc)
		 * @return String (kelanjutan kueri filter)
		 **/
		if(!$filtered['category'] AND !$filtered['supplier']) :
			$where = false;
		elseif($filtered['category'] AND $filtered['supplier']) :
			$where = "WHERE tb_product.category_product = '{$filtered['category']}' AND tb_product.ID_supplier = '{$filtered['supplier']}'";
		elseif($filtered['category'] AND !$filtered['supplier']) :
			$where = "WHERE tb_product.category_product = '{$filtered['category']}'";
		elseif(!$filtered['category'] AND $filtered['supplier']) :
			$where = "WHERE tb_product.ID_supplier = '{$filtered['supplier']}'";
		endif;
		return $where;
	}
	private function query_get($filtered, $limit = 20, $offset = 0)
	{
		/**
		 * Query menampilkan produk (berkaittan dengan transaksi)
		 *
		 * @param  Array (Assoc), Integer, Integer
		 * @return Array
		 **/
		$query = $this->db->query("SELECT tb_product.*, tb_category_product.* FROM tb_product INNER JOIN tb_product_stock ON tb_product.ID_product = tb_product_stock.ID_product LEFT JOIN tb_category_product ON tb_product.category_product = tb_category_product.category_product {$this->filtered($filtered)} LIMIT {$limit} OFFSET {$offset}");
		return $query->result();	
	}
	private function query_num($filtered)
	{
		/**
		 * Query menampilkan produk (berkaittan dengan transaksi)
		 *
		 * @param  Array (Assoc)
		 * @return  Num
		 **/
		$query = $this->db->query("SELECT tb_product.*, tb_category_product.* FROM tb_product INNER JOIN tb_product_stock ON tb_product.ID_product = tb_product_stock.ID_product LEFT JOIN tb_category_product ON tb_product.category_product = tb_category_product.category_product {$this->filtered($filtered)}");
		return $query->num_rows();
	}
}

/* End of file Data_product.php */
/* Location: ./application/controllers/Data_product.php */