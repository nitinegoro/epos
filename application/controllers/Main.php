<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Admin_panel 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('harga'));
		
		$this->load->model(array('mtransaction','mproduct', 'cash_balance'));

		$this->load->js(base_url("assets/plugins/slimScroll/jquery.slimscroll.min.js"));
		$this->load->js(base_url("assets/plugins/chartjs/Chart.min.js"));
		$this->load->js(base_url("assets/js_app/dashboard.js"));
	}
	public function index()
	{
		$data = array(
			'title' => 'Halaman Utama',
		);
		$this->template->view('main/utama', $data);
	}

	public function addsaldo()
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
				'message' => "Data berhasil disimpan"
			);
		} else {
			$this->data = array(
				'status' => false,
				'message' => "Gagal saat menyimpan data!"
			);
		}

		redirect('main');
	}

	public function getsaldo($param = 0)
	{
		$this->data = $this->db->get_where('cash_balance', array('ID' => $param))->row();

		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function deletecash($param = 0)
	{
		$this->data = $this->cash_balance->delete( $param );

		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function updatecash($param = 0)
	{
		$this->db->update('cash_balance', array(
			'amount' => str_replace(',', '', $this->input->post('amount')),
			'description' => $this->input->post('description'),
		), array(
			'ID' => $param
		));

		if($this->db->affected_rows())
		{
			$this->data = array(
				'status' => 'success',
				'message' => "Data berhasil disimpan"
			);
		} else {
			$this->data = array(
				'status' => 'failed',
				'message' => "Gagal saat menyimpan data!"
			);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}

	public function getchartdata()
	{
		$tujuKemarin = date('Y-m-d', strtotime("-6 days", strtotime(date('Y-m-d'))));

		$date = array();
		$data = array();
		foreach (date_range($tujuKemarin, date('Y-m-d')) as $key => $value) 
		{
			$valDate = new DateTime($value);
			$date[] = $valDate->format('d M Y');
			$data[] = $this->mtransaction->profit($value);
		}	

		$this->data['labels'] = $date;
		$this->data['datasets'] = array(
			array(
				'label' => 'Digital Goods',
		        'fillColor' => 'rgba(60,141,188,0.9)',
		        'strokeColor' => 'rgba(60,141,188,0.8)',
		        'pointColor' => '#3b8bba',
		        'pointStrokeColor' => 'rgba(60,141,188,1)',
		        'pointHighlightFill' => '#fff',
		        'pointHighlightStroke' => 'rgba(60,141,188,1)',
		        'title' => "Sale report",
		        'data' => $data
			)
		);

		$this->output->set_content_type('application/json')->set_output(json_encode($this->data));
	}
}
/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
