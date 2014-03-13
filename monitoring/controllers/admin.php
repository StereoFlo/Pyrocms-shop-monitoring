<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Admin_Controller
{
	public $section = 'monitoring';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('monitoring_m');
		$this->load->model('providers_m');
		$this->load->model('network_m');
		$this->load->model('phones_m');
		$this->load->library('form_validation');
		$this->load->library('excel');
		$this->lang->load('monitoring');
		$this->template->append_metadata(css('tip.css', 'monitoring'));
		$this->template->append_metadata(js('jquery.poshytip.min.js', 'monitoring'));
		$this->template->append_metadata("<script type=\"text/javascript\"> $(function(){ $('#tip').poshytip({ className: 'tip-darkgray', bgImageFrameSize: 11, offsetX: -25 }); }); </script>");
		
	}

	public function index()
	{
		$pagination = create_pagination('admin/monitoring/index', $this->monitoring_m->get_shops_count());
		if (isset($_GET['q']))
		{
			$this->data->shops = $this->monitoring_m->search_shops($_GET['q']);
		}
		else
		{
			$this->data->shops = $this->monitoring_m->get_shops($pagination["per_page"], $pagination["current_page"]);
		}
		$this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('admin/index', $this->data);
	}
	
	public function add ()
	{
		$filials = $this->monitoring_m->get_filials(); $this->data->filials = array('' => 'Select one'); foreach ($filials as $f) { $this->data->filials[$f->id] = $f->name; };
		$regions = $this->monitoring_m->get_regions(); $this->data->regions = array('' => 'Select one'); foreach ($regions as $r) { $this->data->regions[$r->id] = $r->name; };
		$this->template->title($this->module_details['name'])->build('admin/form', $this->data);
	}
	
	public function edit ($id = NULL)
	{
		$regions = $this->monitoring_m->get_regions(); $this->data->regions = array('' => 'Select one'); foreach ($regions as $r) { $this->data->regions[$r->id] = $r->name; };
		$this->data->shop = $this->monitoring_m->get_shop($id);
		$this->template->title($this->module_details['name'])->build('admin/form', $this->data);
	}
	
	public function delete ($id = NULL)
	{
		$this->monitoring_m->delete_shop($id);
		$this->network_m->delete_network_by_shop($id);
		$this->network_m->delete_ips($id);
		$this->monitoring_m->delete_notices_by_shop($id);
		$this->phones_m->update_phone(array('shop_id' => $id, 'shop_id' => NULL));
		$this->session->set_flashdata('success', "delete successfully");
		redirect ('/admin/monitoring');
	}
	
	public function save ()
	{
		if (isset($_POST) and isset($_POST['id']))
		{
			$this->monitoring_m->update_shop($_POST);
			$this->session->set_flashdata('success', 'updated successfully');
			redirect ('/admin/monitoring');
		}
		elseif (isset($_POST) and empty($_POST['id']))
		{
			$this->monitoring_m->add_shop($_POST);
			$this->session->set_flashdata('success', 'added successfully');
			redirect ('/admin/monitoring');
		}
	}
	

}
