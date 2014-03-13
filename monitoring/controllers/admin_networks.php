<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_networks extends Admin_Controller
{
    public $section = 'networks';
	
    public function __construct()
    {
	parent::__construct();
	$this->load->model('monitoring_m');
        $this->load->model('providers_m');
        $this->load->model('network_m');
	$this->load->library('form_validation');
	$this->lang->load('monitoring');
	$this->template->append_metadata(css('tip.css', 'monitoring'));
	$this->template->append_metadata(js('jquery.poshytip.min.js', 'monitoring'));
	$this->template->append_metadata("<script type=\"text/javascript\"> $(function(){ $('#tip').poshytip({ className: 'tip-darkgray', bgImageFrameSize: 11, offsetX: -25 }); }); </script>");
    }
        
    public function index()
    {
	$pagination = create_pagination('admin/networks/index', $this->network_m->get_networks_count());
	$networks = $this->network_m->get_networks($pagination["per_page"], $pagination["current_page"]);
        $network_arr = array();
        $i = 0; foreach ($networks as $network)
        {
	    $s = $this->monitoring_m->get_shop($network->shop_id);
	    $p = $this->providers_m->get_provider($network->provider_id);
	    if (isset($s[0]->id) and isset($s[0]->name))
	    {
		$network_arr[$i]['shop_id'] = $s[0]->id;
		$network_arr[$i]['shop_name'] = $s[0]->name;
	    }
	    if (isset($p[0]->id) and isset($p[0]->name))
	    {
		$network_arr[$i]['provider_id'] = $p[0]->id;
		$network_arr[$i]['provider_name'] = $p[0]->name;    
	    }
            
            $network_arr[$i]['id'] = $network->id;
            $network_arr[$i]['ip'] = $network->ip;
            $network_arr[$i]['mask'] = $network->mask;
            $network_arr[$i]['gate'] = $network->gate;
            $network_arr[$i]['type'] = $network->type;
            $i++;
        }
        $this->data->networks = $network_arr;
	$this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('admin/networks/index', $this->data);
    }
    
    public function add ()
    {
	$this->template->title($this->module_details['name'])->build('admin/networks/form', $this->data);
    }
    
    public function edit ($id = NULL)
    {
	$this->data->provider = $this->network_m->get_network($id);
	$this->template->title($this->module_details['name'])->build('admin/networks/form', $this->data);
    }
    
    public function delete ($id = NULL)
    {
	$this->network_m->delete_network($id);
	$this->session->set_flashdata('success', "delete successfully");
	if (isset($_SERVER['HTTP_REFERER'])) redirect ($_SERVER['HTTP_REFERER']);
	else redirect ('/admin/monitoring/networks');
    }
    
    public function save ()
    {
	if (isset($_POST) and isset($_POST['id']))
	{
	    $this->network_m->update_network_m($_POST);
	    $this->session->set_flashdata('success', 'updated successfully');
	    redirect ('/admin/monitoring/providers');
	}
	elseif (isset($_POST) and empty($_POST['id']))
	{
	    $this->network_m->add_network_m($_POST);
	    $this->session->set_flashdata('success', 'added successfully');
	    redirect ('/admin/monitoring/providers');
	}
    }
        
}