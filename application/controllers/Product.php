<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_panel 
{
	public $data;

	public $per_page;

	public $page;

	public $query;

	public function __construct( )
	{
		parent::__construct();

		$this->load->library(array('harga','pagination','custom','upload','image_lib','cropping','datatables'));

		$this->load->model(array('mproduct'));

		$this->per_page = (!$this->input->get('per_page')) ? 20 : $this->input->get('per_page');

		$this->page = $this->input->get('page');

		$this->query = $this->input->get('query');

		$this->load->js(base_url("assets/js_app/app_product.js"));
	}

	public function index()
	{
		$config = $this->template->pagination_list();

		$config['base_url'] = base_url("product?per_page={$this->per_page}&query={$this->query}");

		$config['per_page'] = $this->per_page;
		$config['total_rows'] = $this->mproduct->getall(null, null, 'num');

		$this->pagination->initialize($config);

		$data = array(
			'title' => 'Data Produk', 
			'products' =>  $this->mproduct->getall($this->per_page, $this->page)
		);

		$this->template->view('product/data-produk', $data); 
	}

	public function create()
	{
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('code', 'kode produk', 'trim|required|is_unique[tb_product.product_code]');
		$this->form_validation->set_rules('unit', 'satuan', 'trim|required');
		$this->form_validation->set_rules('category', 'kategori', 'trim|required');
		$this->form_validation->set_rules('stock', 'stock', 'trim|required');
		$this->form_validation->set_rules('purchase', 'Harga Beli', 'trim|required');
		$this->form_validation->set_rules('default_price', 'Harga Jual Umum', 'trim|required');
		$this->form_validation->set_rules('reseller_price', 'Harga Jual Grosir', 'trim|required');

		if( $this->form_validation->run() == TRUE )
		{
			$this->mproduct->create();

			redirect(current_url());
		} 

		$data = array(
			'title' => 'Tambah Data Produk'
		);

		$this->template->view('product/create-produk', $data); 
	}

	public function update($param = 0)
	{
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('code', 'kode produk', 'trim|required');
		$this->form_validation->set_rules('unit', 'satuan', 'trim|required');
		$this->form_validation->set_rules('category', 'kategori', 'trim|required');
		$this->form_validation->set_rules('stock', 'stock', 'trim|required');
		$this->form_validation->set_rules('purchase', 'Harga Beli', 'trim|required');
		$this->form_validation->set_rules('default_price', 'Harga Jual Umum', 'trim|required');
		$this->form_validation->set_rules('reseller_price', 'Harga Jual Grosir', 'trim|required');

		if( $this->form_validation->run() == TRUE )
		{
			$this->mproduct->update($param);

			redirect(current_url());
		} 

		$data = array(
			'title' => 'Tambah Data Produk',
			'get' => $this->mproduct->get($param)
		);

		$this->template->view('product/update-product', $data); 
	}

	/**
	 * Menghapus Data Produk
	 *
	 * @return string
	 **/
	public function delete($param = 0)
	{
		$this->db->delete('tb_product', array('ID'=> $param ));

		redirect('data_transaksi');
	}

	public function data_list()
	{
		/**
		 * Menampilkan data semua product (pada tombol pencarian manual) 
		 *
		 * @return string
		 **/
		$query = $this->db->query("SELECT tb_product.* FROM tb_product")->result();
		$output['data'] = array();
		foreach($query as $row) :
			$output['data'][] = array(
				$row->product_code,
				$row->product_name,
				$row->stock,
				$row->product_unit,
				'Rp. '.number_format($row->default_price),
				'Rp. '.number_format($row->reseller_price),
				'<a href="#" class="btn btn-warning btn-xs" onclick="add_cart_cari('."'".$row->product_code."'".');" data-toggle="tooltip" data-placement="top" title="Tambahkan ke Transaksi"><i class="fa fa-plus"></i></a>'
			);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */