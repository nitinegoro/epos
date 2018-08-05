<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Supplier aplikasi
 * Aplikasi Management Toko Charlie
 * Halaman supplier dan management supplier.
 *
 * TODO DESCRIPTION
 * @return 
 * 		http://127.0.0.1/examplae_root/index.php/supplier
 *	- atau ( .htaccess ) -
 * 		http://127.0.0.1/examplae_root/supplier
 * @package Supplier
 * @author https://www.facebook.com/muh.azzain
 * @see http://www.teitramega.com/
 **/
class Supplier extends CI_Controller {
	public function __construct( )
	{
		parent::__construct();
		if ( ! $this->session->userdata('is_login') ) :
			redirect('login');
			return;
		endif;
		$this->load->library(array('harga','pagination','custom'));
	}
	public function index()
	{
        $config = pagination_list();
        /*  Note : Membuat URL pada default atau dengan method pencarian 'q' ( enable query String 'enabled' ) */
        if ( ! $this->input->get('q') ) {
            $config['base_url'] = site_url('supplier');
            $config['total_rows'] = $this->db->count_all('tb_supplier');
        } else {
            $config['base_url'] = site_url('supplier?q='.$this->input->get('q'));
            $config['total_rows'] = $this->db->query("SELECT * FROM tb_supplier WHERE name LIKE '%{$this->input->get('q')}%' OR address LIKE '%{$this->input->get('q')}%' OR phone LIKE '%{$this->input->get('q')}%' OR email LIKE '%{$this->input->get('q')}%'")->num_rows();
        }
		$config['per_page'] = 50;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $search = ( ! $this->input->get('q') ) ? 0 : $this->input->get('q');

		$data = array(
			'title' => 'Data Supplier'.DEFAULT_TITLE, 
			'supplier' => $this->query_supplier($search, $config['per_page'], $page)
		);
		$this->template->view('supplier/all_supplier', $data);
	}
	public function query_supplier( $search, $limit = 50, $offset = 0 )
	{
		/**
		 * Query menampilkan data Supllier 
		 *
		 * @param String, Integer, Integer
		 * @return Result Array
		 **/
		if(!$search) :
			$query = $this->db->query("SELECT * FROM tb_supplier ORDER BY ID_supplier DESC LIMIT {$limit} OFFSET {$offset}");
		else :
			$query = $this->db->query("SELECT * FROM tb_supplier WHERE name LIKE '%{$search}%' OR address LIKE '%{$search}%' OR phone LIKE '%{$search}%' OR email LIKE '%{$search}%' LIMIT {$limit} OFFSET {$offset}");
		endif;
		return $query->result();
	}
	public function get( $ID = 0)
	{
		/**
		 * Menampilkan data supplier by PRI_INDEX
		 *
		 * @param Integer
		 * @return string
		 **/
		$query = $this->db->query("SELECT * FROM tb_supplier WHERE ID_supplier = '{$ID}'");
		if (!$query->num_rows()) :
			$output['status'] = false;
		else :
			$data = $query->row();
			$output = array(
				'status' => true, 
				'result' => array(
					'name' => $data->name,
					'address' => $data->address,
					'phone' => $data->phone,
					'email' => $data->email
				)
			);
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function insert_supplier()
	{
		/**
		 * Menambahkan Supplier Baru
		 *
		 * @return string
		 **/
		$object = array(
			'name' => $this->input->post('nama'),
			'address' => $this->input->post('alamat'),
			'phone' => $this->input->post('telp'),
			'email' => $this->input->post('email') 
		);
		$insert = $this->db->insert('tb_supplier', $object);
		if ($insert):
			$output = array('status' => true, 'ref' => site_url('supplier'));
		else :
			$output['status'] = false;
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	public function update_supplier( $ID = 0 )
	{
		/**
		 * Mengubah data Supllier
		 *
		 * @param Integer
		 * @return String
		 **/
		$object = array(
			'name' => $this->input->post('nama'),
			'address' => $this->input->post('alamat'),
			'phone' => $this->input->post('telp'),
			'email' => $this->input->post('email') 
		);
		$update = $this->db->update('tb_supplier', $object, array('ID_supplier' => $ID));
		if ($update) :
			$output = array('status' => true, 'ref' => site_url('supplier') );
		else :
			$output['status'] = false;
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	public function delete_supplier( $ID = 0)
	{
		/**
		 * Menghapus data Supplier
		 *
		 * @param Integer
		 * @return String
		 **/
		$delete = $this->db->delete('tb_supplier', array('ID_supplier' => $ID));
		$output['status'] = ($delete) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	public function data_ajax()
	{
		/**
		 * Menampilkan Data Supplier Ajax
		 *
		 * @return String Object
		 **/
		$query = $this->db->query("SELECT * FROM tb_supplier ORDER BY ID_supplier DESC");
		$output = array(
			'data' => array(),
		);
		$no = $this->input->post('start');
		foreach ($query->result() as $row) :
			$output['data'][] = array(
				++$no.'.', 
				$row->name,
				$row->phone,
				$row->address,
				'<button type="submit" class="btn btn-xs btn-danger" onclick="create_product_supplier('."'".$row->ID_supplier."'".');"><i class="fa fa-plus"></i></button>'
			);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function detail_supplier( $ID = 0)
	{
		/**
		 * menampilkan Halaman detail suppplier dan produk
		 *
		 * @return Halaman Detail Supplier
		 **/
		$query = $this->db->query("SELECT * FROM tb_supplier WHERE ID_supplier = '{$ID}'")->row();
		$data = array(
			'title' => $query->name.DEFAULT_TITLE, 
			'row' => $query,
		);
		$this->template->view('supplier/detail_supplier', $data);
	}
	public function get_product( $ID = 0)
	{
		/**
		 * Mengambil query Product by Supplier
		 *
		 * @param Integer (PRI_INDEX_SUPPLIER)
		 * @return Array
		 **/
		$query = $this->db->query("SELECT tb_product.*, tb_product_stock.*, tb_category_product.* FROM tb_product JOIN tb_product_stock ON tb_product.ID_product = tb_product_stock.ID_product LEFT JOIN tb_category_product ON tb_product.category_product = tb_category_product.category_product WHERE tb_product.ID_supplier = '{$ID}'");
		$output = array(
			'data' => array(),
		);
		$no = $this->input->post('start');
		foreach ($query->result() as $row) :
			$output['data'][] = array(
				++$no.'.', 
				$row->ID_product,
				$row->product_name,
				$row->category,
				$row->stock,
				$row->product_satuan,
				'Rp. '.number_format($row->purchase),
				'Rp. '.number_format($this->harga->get(1, $row->ID_product)),
				'Rp. '.number_format($this->harga->get(2, $row->ID_product)),
				'<a href="#" class="text-red" onclick="del_product_supplier('."'".$row->ID_product."',".''."'".$row->product_name."'".');" data-toggle="tooltip" data-placement="top" title="Hapus Produk ini"><i class="fa fa-trash-o"></i></a>'
			);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function all_product( $ID = 0)
	{
		/**
		 * Menampilkan query Semua product pada tombol Tambahkan product ke supplier
		 *
		 * @param Integer - ID_supplier (Sebagai PRI_INDEX Supplier)
		 * @var string
		 **/
		$query = $this->db->query("SELECT tb_product.*, tb_product_stock.*, tb_category_product.* FROM tb_product JOIN tb_product_stock ON tb_product.ID_product = tb_product_stock.ID_product LEFT JOIN tb_category_product ON tb_product.category_product = tb_category_product.category_product");
		$output = array(
			'data' => array(),
		);
		$no = $this->input->post('start');
		foreach ($query->result() as $row) :
			$output['data'][] = array(
				++$no.'.', 
				$row->ID_product,
				$row->product_name,
				$row->category,
				$row->stock,
				$row->product_satuan,
				'<a href="#" class="btn btn-danger btn-xs" onclick="add_product_supplier('."'".$row->ID_product."',".''."'".$ID."'".');" data-toggle="tooltip" data-placement="top" title="Tambahkan Produk ini"><i class="fa fa-plus"></i></a>'
			);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function add_product($ID=0, $SUP=0)
	{
		/**
		 * Menambahkan Product pada supplier (Update tb_product)
		 *
		 * @param Integer (ID_prodcut, ID_supplier)
		 * @return string
		 **/
		$update = $this->db->update('tb_product', array('ID_supplier' => $SUP), array('ID_product' => $ID));
		$output['status'] = ($update) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	public function del_product($ID=0)
	{
		/**
		 * Menghapus Product pada supplier (Update tb_product)
		 *
		 * @param Integer (ID_prodcut)
		 * @return string
		 **/
		$update = $this->db->update('tb_product', array('ID_supplier' => 0), array('ID_product' => $ID));
		$output['status'] = ($update) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
}

/* End of file Supplier.php */
/* Location: ./application/controllers/Supplier.php */