<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Custom
{
	protected $CI;

	public function __construct()
	{
        $this->CI =& get_instance();
	}
	public function get_category_sales( $ID = 0 )
	{
		/**
		 * Query untuk menampilakn Category Penjualan All Or by ID
		 *
		 * @param Integer
		 * @return Result Array
		 **/
		if ( ! $ID ) :
			$query = $this->CI->db->query("SELECT * FROM tb_category_sales")->result();
		else :
			$query = $this->CI->db->query("SELECT * FROM tb_category_sales WHERE ID_category = '{$ID}'")->row();
		endif;
		return $query; 
	}
	public function get_category_product( $ID = 0 )
	{
		/**
		 * Menampilkan Query Category Product
		 *
		 * @param Integer
		 * @return Result Array (not parameter) / String (with parameter) 
		 **/
		if (!$ID) :
			$query = $this->CI->db->query("SELECT * FROM tb_category_product")->result();
		else :
			$query = $this->CI->db->query("SELECT category FROM tb_category_product WHERE category_product = '{$ID}'")->row();
		endif;
		return $query; 
	}
	public function get_supplier( $ID = 0)
	{
		/**
		 * Menampilkan Query Supplier
		 *
		 * @param Integer
		 * @return Result Array (not parameter) / String (with parameter) 
		 **/
		if (!$ID) :
			$query = $this->CI->db->query("SELECT * FROM tb_supplier")->result();
		else :
			$query = $this->CI->db->query("SELECT * FROM tb_supplier WHERE ID_supplier = '{$ID}'")->row();
		endif;
		return $query; 
	}
   	public function code_factur() { 
   		/**
   		 * Membbuat kode faktur otomatis
   		 *
   		 * @param default
   		 * @return Integer 
   		 **/
        $query = $this->CI->db->query("SELECT MAX(ID_transaction) AS ID_transaction, user_id FROM tb_transaction");

  		$data = $query->row();

  		$max_id = $data->ID_transaction; 

  		$max_id1 = (int) substr( $max_id, 1, 6 );

		$no_factur = ++$max_id1;

		$max_no_factur = $data->user_id.sprintf("%06s",$no_factur).date('mY');

		return $max_no_factur;
   	} 
}

/* End of file Custom.php */
/* Location: ./application/libraries/Custom.php */
