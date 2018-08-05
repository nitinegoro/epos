<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_transaksi extends Admin_panel 
{
	public $data;

	public $per_page;

	public $page;

	public $query;

	public $from;

	public $to;

	public $cashier;

	private $filtered = array();

	public function __construct( )
	{
		parent::__construct();

		$this->load->helper(array('indonesia'));

		$this->load->library(array('harga','pagination','custom','cart'));

		$this->load->model(array('mproduct','mtransaction','musers','cash_balance'));

		$this->per_page = (!$this->input->get('per_page')) ? 20 : $this->input->get('per_page');

		$this->page = $this->input->get('page');

		$this->query = $this->input->get('query');

		$this->from = (!$this->input->get_post('from')) ? '0000-00-00' : $this->input->get('from');

		$this->to = (!$this->input->get('to')) ? date('Y-m-d') : $this->input->get('to');

		$this->cashier = $this->input->get('kasir');

		$this->load->js(base_url("assets/js_app/transaksi.js"));
	}

	public function index()
	{
		$config = $this->template->pagination_list();

		$config['base_url'] = base_url("data_transaksi?per_page={$this->per_page}&query={$this->query}&from={$this->from}&to={$this->to}&kasir={$this->cashier}");

		$config['per_page'] = $this->per_page;
		$config['total_rows'] = $this->mtransaction->getall(null, null, 'num');

		$this->pagination->initialize($config);

		$data = array(
			'title' => 'Data Transaksi', 
			'transaksi' =>  $this->mtransaction->getall($this->per_page, $this->page)
		);

		$this->template->view('laporan/data-transaksi', $data); 
	}

	public function update($param = 0)
	{
		$this->load->js(base_url("assets/js_app/update-transaksi.js"));

		$data = array(
			'title' => 'Ubah Data Transaksi', 
			'transaksi' =>  $this->mtransaction->get($param)
		);

		$this->template->view('laporan/ubah-transaksi', $data); 
	}

	public function getdataupdate( $param = 0 )
	{
		$output = array(
			'data' => array(),
		);
		
		$no = $this->input->post('start');

		foreach ($this->mtransaction->getProductItems($param) as $key => $value) 
		{
			$output['data'][] = array(
				++$no.'.', 
				$value->product_code, 
				$value->product_name,
				$value->quantity,
				$value->product_unit,
				'Rp. '.number_format($value->price),
				'Rp. '.number_format($value->price*$value->quantity),
				'<a href="#" class="btn btn-primary btn-xs" onclick="update_cart('."'".$value->product_code."'".');"><i class="fa fa-pencil"></i></a>
				<a href="#" class="btn btn-danger btn-xs" onclick="delete_cart('."'".$value->product."'".');"><i class="fa fa-trash-o"></i></a>'
			);
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}

	public function get_total()
	{
		$total = 0;

		foreach ($this->mtransaction->getProductItems($this->input->post('transaksi')) as $key => $value) 
			$total += ($value->price*$value->quantity);

		$output['total'] = 'Rp. '.number_format($total);

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function addedcart($param = 0)
	{
		$product = $this->db->query("SELECT * FROM tb_product WHERE product_code = '{$param}'")->row();

		$items = $this->mtransaction->getItemByCode($param);

		$qty = $this->input->post('qty');

		if ($qty > $product->stock) 
		{
			$output = array(
				'status' => false,
				'message' => '<p>Stock tidak mencukupi,</p><p>Silahkan lakukan Update Stock terlebih dahulu.</p>'
			);
		} else {
				$this->db->insert('tb_detail_transaction', array(
					'ID_transaction' => $this->input->post('transaction'),
					'product' => $product->ID,
					'quantity' => $qty,
					'price' => ($this->input->post('selling_type')=='umum') ? $product->default_price : $product->reseller_price
				));
			$this->db->update('tb_product', array(
				'stock' => ($product->stock-$qty)
			), array(
				'ID' => $product->ID
			));

			$output = array(
				'status' => true, 
				'ref' => site_url('transaksi'),
				'result' => array('stock' => $product->stock,'unit'=> $product->product_unit),
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function updatecart($param = 0)
	{
		$product = $this->db->query("SELECT * FROM tb_product WHERE product_code = '{$param}'")->row();

		$items = $this->mtransaction->getItemByCode($param);

		$qty = $this->input->post('qty');

		if($qty == 0)
		{
			$this->db->update('tb_product', array(
				'stock' => ($product->stock+$items->quantity)
			), array(
				'ID' => $product->ID
			));

			$this->db->delete('tb_detail_transaction', array('product' => $product->ID));
		}

		if($qty < $items->quantity) 
		{
			$jumlahStock = ($product->stock+($items->quantity-$qty));
		} else if($qty > $items->quantity) {
			$jumlahStock = ($product->stock-($qty-$items->quantity));
		} else if($items->quantity == $qty) {
			$jumlahStock = $product->stock;
		}

		if( $jumlahStock < 0  )
		{
			$output = array(
				'status' => false,
				'message' => '<p>Stock tidak mencukupi,</p><p>Jumlah stock produk ini : <strong>'.$product->stock.' '.$product->product_unit.'</strong></p>'
			);
		} else {
			$this->db->update('tb_product', array(
				'stock' => $jumlahStock
			), array(
				'ID' => $product->ID
			));

			$this->db->update('tb_detail_transaction', array(
				'quantity' => $qty
			), 
			array(
				'id' => $items->id
			));

			$output = array(
				'status' => true, 
				'message' => $jumlahStock,
				'result' => array('stock' => $product->stock,'unit'=> $product->product_unit),
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function get_cart( $param = 0 , $byCode = NULL)
	{
		if($byCode == NULL) {
			$product = $this->mtransaction->getItemById($param);
		} else {
			$product = $this->mtransaction->getItemByCode($param);
		}
	
		$output = array(
			'data' => array($this->db->last_query()),
		);

		if ( $product ) 
		{
			$output['status'] = true;
			$output['result'] = array(
				'id' => $product->product,
				'ID_product' => $product->product_code,
				'product_name' => $product->product_name,
				'qty' => $product->quantity,
				'unit' => $product->product_unit,
				'price' => number_format($product->price),
				'total' => number_format($product->price*$product->quantity)
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function delete_item($param = 0)
	{
		$product = $this->db->query("SELECT * FROM tb_product WHERE ID = '{$param}'")->row();

		$item = $this->mtransaction->getItemById($param);

		$this->db->update('tb_product', array(
			'stock' => ($product->stock+$item->quantity)
		), array(
			'ID' => $item->product
		));

		$this->db->delete('tb_detail_transaction', array('product' => $param));

		$this->output->set_content_type('application/json')->set_output(json_encode(array('status' => true)));
	}

	public function hitung( $bayar = 0 )
	{
		$total = 0;
		$transaksi = $this->mtransaction->get($this->input->post('transaksi'));
		foreach ($this->mtransaction->getProductItems($this->input->post('transaksi')) as $key => $value) 
			$total += ($value->price*$value->quantity);

		if ( $bayar >= $total  ) 
		{
			$this->db->update('tb_transaction', array(
				'total' => $total,
				'paid' => $bayar
			), array(
				'ID_transaction' => $this->input->post('transaksi')
			));
			$output['status'] = true;
			$kembalian = number_format($bayar - $total);
			$output['kembali'] = $kembalian;
		} else {
			$output['status'] = false;
			$output['kurang'] = number_format($bayar - $total);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	/**
	 * Menghapus Data Transaksi
	 *
	 * @return string
	 **/
	public function delete_transaksi($param = 0)
	{
		$this->db->delete('tb_transaction', array('ID_transaction'=> $param ));
		$this->db->delete('tb_detail_transaction', array('ID_transaction'=> $param ));

		redirect('data_transaksi');
	}

	public function report()
	{
		$config = $this->template->pagination_list();

		$config['base_url'] = base_url("data_transaksi?per_page={$this->per_page}&query={$this->query}&from={$this->from}&to={$this->to}&kasir={$this->cashier}");

		$config['per_page'] = $this->per_page;
		$config['total_rows'] = $this->mtransaction->getall(null, null, 'num');

		$this->pagination->initialize($config);

		$data = array(
			'title' => 'Buat Laporan Transaksi', 
			'transaksi' =>  $this->mtransaction->getall($this->per_page, $this->page)
		);

		$this->template->view('laporan/buat-laporan', $data); 
	}

	public function cetaklaporan()
	{
		$data = array(
			'title' => 'Cetak Laporan Transaksi', 
			'transaksi' =>  $this->mtransaction->getall($this->per_page, $this->page)
		);

		$this->load->view('themes/laporan/cetak-laporan', $data); 
	}
}

/* End of file Data_transaksi.php */
/* Location: ./application/controllers/Data_transaksi.php */