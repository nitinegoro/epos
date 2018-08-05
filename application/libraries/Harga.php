<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Menampilakan harga produk
 *
 * @param Integer
 * @author https://www.facebook.com/muh.azzain
 **/
class Harga
{
	protected $CI;

	public function __construct()
	{
        $this->CI =& get_instance();
	}
	public function get( $category = 0, $product = 0  )
	{
		/**
		 * undocumented class
		 *
		 * @package default
		 * @return String {category_name}
		 **/
		$query = $this->CI->db->query("SELECT price FROM tb_product_price WHERE ID_category = '{$category}' AND ID_product = '{$product}'");
		if ( ! $query->num_rows() ) :
			return false;
		else :
			return  $query->row()->price;
		endif;
	}
}

/* End of file Harga.php */
/* Location: ./application/libraries/Harga.php */
