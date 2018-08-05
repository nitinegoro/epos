<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Login aplikasi
 * Aplikasi Management Toko Charlie
 * Index halaman transaksi penjualan.
 *
 * @return 
 * 		http://127.0.0.1/examplae_root/index.php/transaksi
 *	- atau ( .htaccess ) -
 * 		http://127.0.0.1/examplae_root/transaksi
 * @package master utama
 * @author https://www.facebook.com/muh.azzain
 * @see http://www.teitramega.com/
 **/
class Transaksi extends Admin_panel 
{
	public function __construct( )
	{
		parent::__construct();

		$this->load->library(array('harga','cart','custom'));

		$this->load->js(base_url("assets/js_app/app_transaction.js"));
	}

	public function index()
	{
		$data = array(
			'title' => 'Transaksi', 
		);
		$this->template->view('transaksi/main_transaksi', $data);
	}	

	public function insert_cash_balance()
	{
		if($this->input->post())
		{
			$this->db->insert('cash_balance', array(
				'date' => date('Y-m-d H:i:s'),
				'mutation' => $this->input->post('mutation'),
				'amount' => str_replace(',', '', $this->input->post('amount')),
				'description' => $this->input->post('description'),
				'user_id' => $this->account->id
			));

			if($this->db->affected_rows())
			{
				$this->data = array(
					'status' => true,
					'message' => "Data berhasil diseimpan"
				);
			} else {
				$this->data = array(
					'status' => false,
					'message' => "Gagal saat menyimpan data!"
				);
			}
		} else {
			$this->data = array(
				'status' => false,
				'message' => "Method yang digunakan tidak sesuai!"
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function list_data( )
	{
		/**
		 * Menampilkan list Keranjang belanja
		 *
		 * @return String (Object) Array
		 **/
		$peserta = $this->cart->contents();
		$output = array(
			'data' => array(),
		);
		$no = $this->input->post('start');
		foreach ($peserta as $row) :
			$output['data'][] = array(
				++$no.'.', 
				$row['ID_product'], 
				$row['name'],
				$row['qty'],
				$row['satuan'],
				'Rp. '.number_format($row['price']),
				'Rp. '.number_format($row['subtotal']),
				'<a href="#" class="btn btn-primary btn-xs" onclick="update_cart('."'".$row['rowid']."',".''."'".$row['ID_product']."'".');"><i class="fa fa-pencil"></i></a>
				<a href="#" class="btn btn-danger btn-xs" onclick="delete_cart('."'".$row['rowid']."',".''."'".$row['ID_product']."'".');"><i class="fa fa-trash-o"></i></a>'
			);
		endforeach;
		$this->output->set_content_type('application/json')->set_output(json_encode($output, JSON_PRETTY_PRINT));
	}
	public function get_total()
	{
		$output['total'] = 'Rp. '.number_format($this->cart->total());
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	public function get_data( $ID = 0 )
	{
		/**
		 * Menampilkan data yang diinput oleh mesin tembak
		 *
		 * @return string data Json
		 **/
		$query = $this->db->query("SELECT * FROM tb_product WHERE product_code = '{$ID}'");
		
		if ( ! $query->num_rows() ) 
		{
			$output['status'] = false;
		} else {
			$data = $query->row();
			$output['status'] = true;
			$output['result'] = array(
				'ID_product' => $data->product_code,
				'product_name' => $data->product_name,
				'stock' => $data->stock,
				'unit' => $data->product_unit,
				'general_price' => 'Rp. '.number_format( $data->default_price ),
				'seller_price' => 'Rp. '.number_format( $data->reseller_price )			
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function get_cart( $ID = 0 )
	{
		/**
		 * Menampilkan Produk yang telah masuk kekeranjang
		 *
		 * @param String
		 * @return Array
		 **/
		$data = $this->cart->get_item( $ID );
		if ( $data ) :
			$output['status'] = true;
			$output['result'] = array(
				'id' => $data['id'],
				'ID_product' => $data['ID_product'],
				'product_name' => $data['name'],
				'qty' => $data['qty'],
				'unit' => $data['satuan'],
				'price' => number_format($data['price']),
				'total' => number_format($data['subtotal']),
				'customer' => $data['customer']
			);
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	public function add( $ID = 0 )
	{
		/**
		 * Menambahkan ke kerangjang belanja
		 *
		 * @param Integer
		 * @return callback  
		 **/
		$row = $this->db->query("SELECT * FROM tb_product WHERE product_code = '{$ID}'")->row();
			
		$data = array(
			'id'      => $ID.'-'.$this->input->post('selling_type'),
			'ID_product' => $row->product_code,
			'qty'     => $this->input->post('qty'),
			'price'   => ($this->input->post('selling_type')=='umum') ? $row->default_price : $row->reseller_price,
			'name'    => $row->product_name,
			'satuan'  => $row->product_unit,
			'customer' => $this->input->post('selling_type')
		);

		$qty = $this->input->post('qty');

		if ($qty > $row->stock) 
		{
			$output = array(
				'status' => false,
				'message' => '<p>Stock tidak mencukupi,</p><p>Silahkan lakukan Update Stock terlebih dahulu.</p>'
			);
		} else {
			$insert =  $this->cart->insert($data);
			$output = array(
				'status' => true, 
				'ref' => site_url('transaksi'),
				'result' => array('stock' => $row->stock,'unit'=> $row->product_unit),
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function delete( $ID = 0 )
	{
		/**
		 * Menghapus salah satu barang dikeranjang
		 *
		 * @param String (id dari cart session) 
		 * @return String
		 **/
		if ( $this->cart->remove( $ID ) ) :
			$output = array('status' => true);
		else :
			$output = array('status' => false, 'error' => 'Gagal!');
		endif;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function update( $ID = 0 )
	{
		/**
		 * Mengubah data pada keranjang
		 *
		 * @param String (id dari cart session) 
		 * @return String
		 **/
		$data = array(
		        'rowid'  => $ID,
		        'qty'    => $this->input->post('qty'),
		        'customer' => $this->input->post('category')
		);
		$cart = $this->cart->get_item( $ID );

		$row = $this->db->query("SELECT * FROM tb_product WHERE product_code = '{$cart['ID_product']}'")->row();

		$qty = $this->input->post('qty') + $cart['qty'];

		if ($qty >= $row->stock) 
		{
			$output = array(
				'status' => false,
				'message' => '<p>Stock tidak mencukupi,</p><p>Silahkan lakukan Update Stock terlebih dahulu.</p>'
			);
		} else {
			$update = $this->cart->update($data);
			$output = array('status' => true, 'ref' => site_url('transaksi'));
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function hitung( $bayar )
	{
		/**
		 * Menghitung uang kembalian belanja
		 * 
		 * @param Integer ( uang yang dibayar )
		 * @return Integer ( kembalian )
		 **/;
		if ( $bayar >= $this->cart->total()  ) {
			$output['status'] = true;
			$kembalian = number_format($bayar - $this->cart->total());
			$output['kembali'] = $kembalian;
		} else {
			$output['status'] = false;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	public function insert_transaction( )
	{
		/**
		 * Menambahkan transaksi baru ( tb_transaction, tb_detail_transaction )
		 *
		 * @return Void
		 **/
		if ( ! count($this->cart->contents()) ) 
		{
			$output = array('status' => false);
		} else {
			$code_factur = $this->custom->code_factur();
			
			$data = array(
				'ID_transaction' => $code_factur, 
				'date' => date('Y-m-d H:i:s'),
				'total' => $this->cart->total(),
				'paid' => str_replace(',', '', $this->input->post('bayar')),
				'user_id' => $this->account->id,
			);
			
			$this->db->insert('tb_transaction', $data);

			foreach ($this->cart->contents() as $item) 
			{
				$productDB = $this->db->query("SELECT stock, ID FROM tb_product WHERE product_code = {$item['ID_product']}")->row(); 
				
				/* Kurangi stock */
				$kurangi = $productDB->stock - $item['qty'];

				$this->db->update('tb_product', array('stock' => $kurangi ), array('ID' =>$productDB->ID));
				/* buat multidimensi */
				$detail_transaction = array(
					'ID_transaction' => $code_factur,
					'product' => $productDB->ID,
					'quantity' => $item['qty'],
					'price' => $item['price'],
				);

				$this->db->insert('tb_detail_transaction', $detail_transaction );
			}

			$output = array(
				'status' => true,
				'ref' => site_url('transaksi/print_transaction/'.$code_factur."?print=yes")
			);
		}

		$this->cart->destroy();
        
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
	}
	
	public function cancel_transaction( )
	{
		/**
		 * Membatalkan transaksi ( destroy session )
		 *
		 * @return Void
		 **/
		$destroy = $this->cart->destroy();
		return redirect( site_url('transaksi') );
	}

	public function print_transaction( $ID = 0 )
	{
		/**
		 * Menampilakn print Out Transaksi
		 *
		 * @return Void (Print Out)
		 **/
		$transaction = $this->db->query("SELECT * FROM tb_transaction WHERE ID_transaction = {$ID}")->row();

		$product = $this->db->query("
			SELECT tb_detail_transaction.*, tb_product.product_name FROM tb_detail_transaction 
			JOIN tb_product ON tb_detail_transaction.product = tb_product.ID 
			WHERE tb_detail_transaction.ID_transaction = {$ID}
		")->result();

		$user = $this->account->id;

		$data = array(
			'transaction' => $transaction, 
			'product' => $product, 'user' => $this->account->name
		);
		$this->load->view('themes/transaksi/print_nota', $data);
	}

}

/* End of file Trasaksi.php */
/* Location: ./application/controllers/Transaksi.php */