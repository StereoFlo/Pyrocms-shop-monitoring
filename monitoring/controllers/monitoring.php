<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('phones_m');
        $this->load->model('monitoring_m');
        $this->load->model('network_m');
        $this->load->model('providers_m');
        $this->template->append_metadata(css('frontend.style.css', 'monitoring'));
	$this->template->append_metadata(css('tip.css', 'monitoring'));
	$this->template->append_metadata(js('jquery.poshytip.min.js', 'monitoring'));
	$this->template->append_metadata("<script type=\"text/javascript\"> $(function(){ $('[id^=tip_]').poshytip({ className: 'tip-darkgray', bgImageFrameSize: 11, offsetX: -25 }); }); </script>");
        if (isset($this->current_user->group) and ($this->current_user->group == 'admin' or $this->current_user->group == 'it-sluzhba-sz'))
        {
            //show_404();
        }
        else
        {
            show_404();
        }
        
    }
    
    public function index ()
    {
	$pagination = create_pagination('monitoring/index', $this->monitoring_m->get_shops_count(), NULL, 3);
	if (isset($_GET['q']))
	{
	    $this->data->shops = $this->monitoring_m->search_shops($_GET['q']);
	}
	else
	{
	    $this->data->shops = $this->monitoring_m->get_shops($pagination["per_page"], $pagination["current_page"]);
	}
	$this->template->title($this->module_details['name'])->set('pagination', $pagination)->build('frontend/monitoring/index', $this->data);
    }
    
    public function view ($id = null)
    {
        if (is_null($id))
        {
            $this->session->set_flashdata('error', 'this shop isnt exists');
            redirect (base_url('monitoring/index'));
        }
        else
        {
            $this->data->notices = $this->monitoring_m->notice_get_by_shop($id);
            $this->data->shop = $this->monitoring_m->get_shop($id);
            $this->data->region = $this->monitoring_m->get_region($this->data->shop[0]->region_id);
            
	    $networks = $this->network_m->get_network_by_shop($id);
	    $addreses = $this->network_m->get_ips($id);
	    
	    $n = 0; foreach ($addreses as $address)
	    {
		$type = $this->network_m->get_type($address->type);
		$this->data->addreses[$n]->id = $address->id;
		$this->data->addreses[$n]->state = $address->state;
		$this->data->addreses[$n]->ip = $address->ip;
		$this->data->addreses[$n]->host = $address->host;
		$this->data->addreses[$n]->type = isset($type->name) ? $type->name : '';
		$n++;
	    }
	    
	    $this->data->active_shop = $id;
	    $i = 0; foreach ($networks as $network)
	    {
		$provider = $this->providers_m->get_provider($network->provider_id);
		$this->data->providers[$i]['id'] = $network->id;
		$this->data->providers[$i]['provider_id'] = $provider[0]->id;
		$this->data->providers[$i]['provider_name'] = $provider[0]->name;
		$this->data->providers[$i]['ip'] = $network->ip;
		$this->data->providers[$i]['mask'] = $network->mask;
		$this->data->providers[$i]['state'] = $network->state;
		$this->data->providers[$i]['gate'] = $network->gate;
		$this->data->providers[$i]['speed'] = $network->speed;
		$this->data->providers[$i]['comment'] = $network->comment;
		$i++;
	    }
            
            $this->template->title($this->module_details['name'])->build('frontend/monitoring/view', $this->data);
        }
    }
}