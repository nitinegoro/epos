<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcategory extends CI_Model {
    /**
     * @name string TABLE_NAME (Nama table)
     */
    const TABLE_NAME = 'tb_category_product';

    /**
     * @name string PRI_INDEX (PK table)
     */
    const PRI_INDEX = 'category_product';

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	/**
	 * Menampilkan Semmua users
	 *
	 * @return Array
	 **/
	public function all()
	{
		$query = $this->db->query("SELECT * FROM tb_category_product ORDER BY category_product DESC");
		return $query->result();
	}


	/**
	 * Menampilkan semua data
	 *
	 * @param Integer
	 **/
	public function index($search, $limit = null, $offset = null )
	{
		if(!$search) :
			$query = $this->db->query("SELECT * FROM tb_category_product ORDER BY category_product DESC LIMIT {$limit} OFFSET {$offset}");
		else :
			$query = $this->db->query("SELECT * FROM tb_category_product WHERE category LIKE '%{$search}%' LIMIT {$limit} OFFSET {$offset}");
		endif;
		return $query->result();
	}

	/**
	 * Menghitung jumlah product berdasarkan kategori
	 *
	 * @return Integer
	 **/
	public function count_product($where=0)
	{
		if(!$where) :
			$query = $this->db->query("SELECT * FROM tb_product");
		else :
			$query = $this->db->query("SELECT * FROM tb_product WHERE category_product = '{$where}'");
		endif;
		return $query->num_rows();
	}

	/**
	 * Mengambil satu data user
	 *
	 * @param Integer
	 **/
    public function get($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::TABLE_NAME);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where(self::PRI_INDEX, $where);
            }
        }
        $result = $this->db->get()->result();
        if ($result) {
            if ($where !== NULL) {
                return array_shift($result);
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }

	/**
	 * Menambah user baru
	 *
	 * @param Array
	 **/
	public function add(Array $data)
	{
        if ($this->db->insert(self::TABLE_NAME, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
	}

	/**
	 * Mengubah data user
	 *
	 * @param Array, Integer
	 **/
    public function update(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array(self::PRI_INDEX => $where);
            }
        $this->db->update(self::TABLE_NAME, $data, $where);
        return $this->db->affected_rows();
    }
	

}

/* End of file Mcategory.php */
/* Location: ./application/models/Mcategory.php */