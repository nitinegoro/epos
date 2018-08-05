<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Category aplikasi
 * Aplikasi Management Toko Charlie
 * Halaman Master Manajemen Kategori.
 *
 * TODO DESCRIPTION
 * @return 
 * 		http://127.0.0.1/examplae_root/index.php/category
 *	- atau ( .htaccess ) -
 * 		http://127.0.0.1/examplae_root/category
 * @package master utama
 * @author https://www.facebook.com/muh.azzain
 * @see http://www.teitramega.com/
 **/
class Category extends Admin_panel 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('harga','pagination'));
		
		$this->load->model(array('mtransaction','mproduct','mcategory'));

		$this->load->js(base_url("assets/js_app/app_category.js"));
	}

	public function index()
	{
        $config = pagination_list();
        /*  Note : Membuat URL pada default atau dengan method pencarian 'q' ( enable query String 'enabled' ) */
        if ( ! $this->input->get('q') ) {
            $config['base_url'] = site_url('category');
            $config['total_rows'] = $this->db->count_all('tb_category_product') - 1; /* Dikurang satu karena data yang dihidden */
        } else {
            $config['base_url'] = site_url('category?q='.$this->input->get('q'));
            $config['total_rows'] = $this->db->query("SELECT * FROM tb_category_product WHERE category LIKE '%{$this->input->get('q')}%'")->num_rows();
        }
		$config['per_page'] = 20;
		$config['uri_segment'] = 4;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $page = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $search = ( ! $this->input->get('q') ) ? 0 : $this->input->get('q');

		$data = array(
			'title' => 'Kategori Produk', 
			'category' => $this->mcategory->index($search, $config['per_page'], $page),
			'count_product' => $config['total_rows']
		);
		$this->template->view('product/all_category', $data);
	}

	/**
	 * Menambahkan Kategori
	 *
	 * @return string
	 **/
	public function add_category()
	{
		for($i=1; $i<= count($this->input->post('cat_add')); $i++) :
			if(!$this->input->post('cat_add['.$i.']')) :
				$nama_kategori = 'Kategori '.$i;
			else :
				$nama_kategori = $this->input->post('cat_add['.$i.']');
			endif;
			$object = array('category' => $nama_kategori );
			$this->db->insert('tb_category_product', $object);
		endfor;
		redirect('category');
	}

	/**
	 * Mengubah Nama Kategori
	 *
	 * @param Integer
	 * @return string
	 **/
	public function update_category($ID=0)
	{
		$update = $this->db->update('tb_category_product', array('category' => $this->input->post('category')), array('category_product'=> $ID));
		if($update) :
			redirect('category');
		else :
			redirect('category');
		endif;
	}

	/**
	 * Menghapus Kategori
	 *
	 * @param Integer
	 * @return string
	 **/
	public function delete_category($ID=0)
	{
		$this->db->update('tb_product', array('category_product'=>1), array('category_product'=>$ID));
		$delete = $this->db->delete('tb_category_product', array('category_product'=>$ID));
		$output['status'] = ($delete) ? true : false;
		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}


	/**
	 * Menghapus Kategori Multiple
	 *
	 * @return string
	 **/
	public function action_multiple()
	{
		switch ($this->input->post('action')) {
			case 'delete':
				for($i=0; $i<count($this->input->post('cat')); $i++) :
					$this->db->update('tb_product', array('category_product'=>1), array('category_product'=>$this->input->post('cat['.$i.']')));
					$this->db->delete('tb_category_product', array('category_product'=>$this->input->post('cat['.$i.']')));
				endfor;
				redirect('category');
				break;
			default:
				redirect('category?bin=pilih_dahulu');
				break;
		}
	}
}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */