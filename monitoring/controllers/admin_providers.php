<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_providers extends Admin_Controller
{
    public $section = 'providers';
	
    public function __construct()
    {
	parent::__construct();
	$this->load->model('monitoring_m');
        $this->load->model('providers_m');
	$this->load->library('form_validation');
	$this->lang->load('monitoring');
	$this->template->append_metadata(css('tip.css', 'monitoring'));
	$this->template->append_metadata(js('jquery.poshytip.min.js', 'monitoring'));
	$this->template->append_metadata("<script type=\"text/javascript\"> $(function(){ $('#tip').poshytip({ className: 'tip-darkgray', bgImageFrameSize: 11, offsetX: -25 }); }); </script>");
    }
        
    public function index()
    {
	if (isset($_GET['q']))
	{
	    $search = $this->providers_m->search_provider($_GET['q']);
	    $this->data->providers = $search[0];
	    $count = count($search[1]);
	}
	else
	{
	    $providers = $this->providers_m->get_providers();
	    $this->data->providers = $providers[0];
	}
	
	$pagination = create_pagination('admin/monitoring/providers/index', isset($_GET['q']) ? $count : $providers[1], null, 5);
	$this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('admin/providers/index', $this->data);
    }
	
    public function view ($id = NULL)
    {
	if ($id == null)
	{
	    $this->providers_m->delete_provider($id);
	    $this->session->set_flashdata('error', "Invalid provider");
	    redirect ('/admin/monitoring/providers');
	}
	else
	{
	    $this->data->provider = $this->providers_m->get_provider($id);
	    $networks = $this->monitoring_m->get_networks_by_provider($id);
	    $this->data->active_provider = $id;
	    $i = 0; foreach ($networks as $network)
	    {
		$shop = $this->monitoring_m->get_shop($network->shop_id);
		
		$this->data->networks[$i]['id'] = $network->id;
		$this->data->networks[$i]['shop_id'] = $shop[0]->id;
		$this->data->networks[$i]['shop_name'] = $shop[0]->name;
		$this->data->networks[$i]['ip'] = $network->ip;
		$this->data->networks[$i]['mask'] = $network->mask;
		$this->data->networks[$i]['gate'] = $network->gate;
		$i++;
	    }
	    $this->template->title($this->module_details['name'])->build('admin/providers/view', $this->data);
	}
    }
    
    public function add ()
    {
	$this->template->title($this->module_details['name'])->build('admin/providers/form', $this->data);
    }
    
    public function edit ($id = NULL)
    {
	$this->data->provider = $this->providers_m->get_provider($id);
	$this->template->title($this->module_details['name'])->build('admin/providers/form', $this->data);
    }
    
    public function delete ($id = NULL)
    {
	$this->providers_m->delete_provider($id);
	$this->session->set_flashdata('success', "delete successfully");
	redirect ('/admin/monitoring/providers');
    }
    
    public function save ()
    {
	if (isset($_POST) and isset($_POST['id']))
	{
	    $this->providers_m->update_provider($_POST);
	    $this->session->set_flashdata('success', 'updated successfully');
	    redirect ('/admin/monitoring/providers');
	}
	elseif (isset($_POST) and empty($_POST['id']))
	{
	    $this->providers_m->add_provider($_POST);
	    $this->session->set_flashdata('success', 'added successfully');
	    redirect ('/admin/monitoring/providers');
	}
    }
        
}