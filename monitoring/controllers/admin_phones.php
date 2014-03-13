<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_phones extends Admin_Controller
{
    public $section = 'phones';
	
    public function __construct()
    {
	parent::__construct();
	$this->load->model('monitoring_m');
	$this->load->model('phones_m');
	$this->load->library('form_validation');
	$this->lang->load('monitoring');
   }
        
    public function index()
    {
	$this->data->pools = $this->phones_m->get_pools();
	$this->template->title($this->module_details['name'])->build('admin/phones/index', $this->data);
    }
    
    public function pools ($action = null, $subaction = null)
    {
	if (!is_null($action))
	{
	    if ($action == 'save')
	    {
		$post = $this->input->post();
		if (!is_null($post))
		{
		    $pool_id = $this->phones_m->add_pool($post);
		    for ($i = $post['start']; $i <= $post['end']; $i++)
		    {
			$data = array();
			$data['pool_id'] = $pool_id;
			$data['shop_id'] = NULL;
			$data['phone'] = $i;
			$this->phones_m->add_phone($data);
		    }
		}
		
		redirect ('/admin/monitoring/phones/');
	    }
	    elseif ($action == 'delete')
	    {
		if (isset($subaction) and is_numeric($subaction))
		{
		    $this->phones_m->delete_pool($subaction);
		    $this->phones_m->delete_phones($subaction);
		}
		$this->session->set_flashdata('success', "delete successfully");
		redirect ('/admin/monitoring/phones/');
	    }
	}
    }
    
    public function phone ($action = null, $subaction = null)
    {
	if (!is_null($action))
	{
	    if ($action == 'assign' and isset($subaction) and is_numeric($subaction))
	    {
		$pool_id = $this->phones_m->get_pool_id($subaction);
		$phones = $this->phones_m->get_phones_free($pool_id->pool_id);
		$phones_dropdown = array('' => 'Select a number'); foreach ($phones as $s) { $phones_dropdown[$s->id] = $s->phone; } $this->data->phones = $phones_dropdown;
		$this->data->active_phone = $this->phones_m->get_phone($subaction);
		
		$shops = $this->monitoring_m->get_shops(); $shops_dropdown = array('' => 'Select a shop');
		foreach ($shops as $s)
		{
		    $phone = $this->phones_m->get_phone_by_shop($s->id);
		    if (!isset($phone->shop_id)) {
			$shops_dropdown[$s->id] = $s->name;
		    }
		}
		$this->data->shops = $shops_dropdown;
		
		$this->template->title($this->module_details['name'])->build('admin/phones/assign', $this->data);
	    }
	    elseif ($action == 'save')
	    {
		$post = $this->input->post();
		$pool_id = $this->phones_m->get_pool_id($post['phone']);
		if (isset($post))
		{
		    $this->phones_m->update_phone($post);
		}
		$this->session->set_flashdata('success', "update successfully");
		redirect ('/admin/monitoring/phones/view/' . $pool_id->pool_id);
	    }
	    elseif ($action == 'clear' and isset($subaction) and is_numeric($subaction))
	    {
		$this->phones_m->update_phone(array('phone' => $subaction, 'shop_id' => NULL));
		$this->session->set_flashdata('success', "update successfully");
		redirect ('/admin/monitoring/phones/');
	    }
	}
    }
    
    public function view ($pool_id = NULL)
    {
	if (!is_null($pool_id) and is_numeric($pool_id))
	{
	    $this->data->pool_id = $pool_id;
	    if (isset($_GET['q']))
	    {
		$phones = $this->phones_m->seach_phones_by_pool($pool_id, $_GET['q']);
	    }
	    else
	    {
		if (isset($_GET['show']) and $_GET['show'] == 'free')
		{
		    $phones = $this->phones_m->get_phones_free($pool_id);
		}
		elseif (!isset($_GET['show']) or (isset($_GET['show']) and $_GET['show'] == 'all'))
		{
		    $phones = $this->phones_m->get_phones_by_pool($pool_id);
		}
	    }
	    foreach ($phones as $key => $val)
	    {
		foreach ($val as $vkey => $value)
		{
		    if ($vkey == 'shop_id' and !is_null($value))
		    {
			$shop = $this->monitoring_m->get_shop($value);
			$this->data->phones[$key]->shop_id = array('id' => $shop[0]->id, 'name' => $shop[0]->name);
		    }
		    else
		    {
			$this->data->phones[$key]->$vkey = $value;
		    }
		}
	    }
	    $this->template->title($this->module_details['name'])->build('admin/phones/view', $this->data);
	}
    }
    
}