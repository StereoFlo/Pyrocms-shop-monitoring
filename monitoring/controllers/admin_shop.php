<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_shop extends Admin_Controller
{
	public $section = 'shop';
	
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
		$this->template->append_metadata("<script type=\"text/javascript\"> $(function(){ $('[id^=tip_]').poshytip({ className: 'tip-darkgray', bgImageFrameSize: 11, offsetX: -25 }); }); </script>");
	}
        
        public function index ()
        {
            
        }
        
        public function view ($id)
        {
	    $this->data->phone = $this->phones_m->get_phone_by_shop($id);
            $this->data->shop = $this->monitoring_m->get_shop($id);
	    $this->data->region = $this->monitoring_m->get_region($this->data->shop[0]->region_id);
	    $this->data->notices = $this->monitoring_m->notice_get_by_shop($id);
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
            $this->template->title($this->module_details['name'])->build('admin/shop/view', $this->data);
        }
	
	public function assign_provider ()
	{
		$this->form_validation->set_rules('ip','set the ip field', 'trim|required');
		$this->form_validation->set_rules('mask', 'set the mask field', 'trim|required');
		$this->form_validation->set_rules('gate', 'set the gate field', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			if (isset($_GET['provider']))
			{
				$this->data->active_provider = $_GET['provider'];
			}
			if (isset($_GET['shop']))
			{
				$this->data->active_shop = $_GET['shop'];
			}
			$providers = $this->providers_m->get_providers(); $providers_dropdown = array('' => 'Select a provider'); foreach ($providers[0] as $p) { $providers_dropdown[$p->id] = $p->name; }
			$shops = $this->monitoring_m->get_shops(); $shops_dropdown = array('' => 'Select a shop'); foreach ($shops as $s) { $shops_dropdown[$s->id] = $s->name; }
			$this->data->providers = $providers_dropdown;
			$this->data->shops = $shops_dropdown;
			$this->template->title($this->module_details['name'])->build('admin/shop/assign_provider', $this->data);
		}
		else
		{
			if(isset($_GET['action']) && $_GET['action']=='save')
			{
				if (isset($_POST) and isset($_POST['id']))
				{
					$this->network_m->update_network($_POST);
					$this->session->set_flashdata('success', 'updated successfully');
					redirect ('/admin/monitoring/shop/view/' . $_POST['shop']);
				}
				elseif (isset($_POST) and empty($_POST['id']))
				{
					$this->network_m->add_network($_POST);
					$this->session->set_flashdata('success', 'added successfully');
					redirect ('/admin/monitoring/shop/view/' . $_POST['shop']);
				}
			}
		}
	}
	
	public function network_add ($shop, $action)
	{
		if ($shop)
		{
			$this->data->shop_id = $shop;
			$action = isset($action) ? $action : '';
			if ($action == '' or $action == 'add')
			{
				$this->template->title($this->module_details['name'])->build('admin/shop/form', $this->data);
			}
			elseif ($action == 'save')
			{
				if ($_POST)
				{
					$range = $this->input->post('network');
					$network = $this->ipListFromRange($range);
					foreach ($network[4] as $r)
					{
						if ($this->network_m->check_ip($r) == 0)
						{
							exec("ping -c 1  " . $r, $output, $result);
							if ($result == 0) $this->network_m->add_ip($shop, $r, gethostbyaddr($r), 1);
							else $this->network_m->add_ip($shop, $r, gethostbyaddr($r), 0);
							
						}
					}
					$this->session->set_flashdata('success', 'added successfully');
					redirect ('/admin/monitoring/shop/view/' . $shop);
				}
			}
		}
	}
	
	public function network_delete ($shop)
	{
		if (!$shop or !is_numeric($shop))
		{
			$this->session->set_flashdata('error', 'error');
			redirect ('/admin/monitoring');
		}
		$this->network_m->delete_ips($shop);
		$this->session->set_flashdata('success', 'deleted successfully');
		redirect ('/admin/monitoring/shop/view/' . $shop);
	}
	
	public function network_update ($shop)
	{
		foreach ($this->network_m->get_ips($shop) as $ip)
		{
			exec("ping -c 1 " . $ip->ip, $output, $result);
			if ($result == 0) $this->network_m->update_state_ip($ip->id, 1, gethostbyaddr($ip->ip));
			else $this->network_m->update_state_ip($ip->id, 0, gethostbyaddr($ip->ip));
		}
		$this->session->set_flashdata('success', 'updated successfully');
		redirect ('/admin/monitoring/shop/view/' . $shop);
	}
	
	public function edit_ip ($action, $id)
	{
		if (isset($action) and $action == 'save' and isset($id))
		{
			$this->data->ip = $this->network_m->get_ip($id);
			$this->network_m->update_ip($id, $_POST['type']);
			$this->session->set_flashdata('success', 'updated successfully');
			redirect ('/admin/monitoring/shop/view/' . $this->data->ip[0]->shop_id);
		}
		else
		{
			$this->data->ip = $this->network_m->get_ip($id);
			$this->data->active_ip = $id;
			$types = $this->network_m->get_types(); $this->data->types = array('' => 'Select one'); foreach ($types as $type) { $this->data->types[$type->id] = $type->name; }
			$this->template->title($this->module_details['name'])->build('admin/shop/form_ip', $this->data);
		}
	}
	
	public function notice ()
	{
		if ($_POST)
		{
			$this->monitoring_m->notice_save($_POST);
			$this->session->set_flashdata('success', 'sent successfully');
			if (isset($_POST['email']))
			{
				$shop = $this->monitoring_m->get_shop($_POST['shop_id']);
				$this->email->set_mailtype("html");
				$this->email->to('sz.support.list@megafon-retail.ru');
				$this->email->from($this->current_user->email, $this->current_user->display_name);
				if ($_POST['notice_id'] == 1) $this->email->subject("[NOTICE] " . $_POST['subject']);
				if ($_POST['notice_id'] == 2) $this->email->subject("[WARNING] " . $_POST['subject']);
				if ($_POST['notice_id'] == 3) $this->email->subject("[ERROR] " . $_POST['subject']);
				$message = "<p>Hi!</p><p>" . $this->current_user->display_name . " create a notice about of " . $shop[0]->name . ":</p><p>" . $_POST['comment'] . "</p><p>------<br/>Best regards, <br/>" . $this->current_user->display_name . "</p>";
				$this->email->message($message);
				$this->email->send();
			}
			redirect ('/admin/monitoring/shop/view/' . $_POST['shop_id']);
		}
		else
		{
			$this->data->active_shop = isset($_GET['shop']) ? $_GET['shop'] : '';
			$shops = $this->monitoring_m->get_shops(); $shops_dropdown = array('' => 'Select a shop'); foreach ($shops as $s) { $shops_dropdown[$s->id] = $s->name; }
			$this->data->shops = $shops_dropdown;
			$this->template->title($this->module_details['name'])->build('admin/shop/form_notice', $this->data);
		}
	}
	
	private function ipListFromRange ($network)
	{
    
		list ($ip_address, $ip_nmask) = explode('/', $network);
		
		$hosts = array();
		if (preg_match("/\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}/i", $ip_nmask))
		{
		    $mask = $ip_nmask;
		}
		else
		{
		    $ta = substr($network, strpos($network, '/') + 1) * 1;
		    $netmask = str_split(str_pad(str_pad('', $ta, '1'), 32, '0'), 8);
		    foreach ($netmask as &$element) $element = bindec($element);
		    $mask = join('.', $netmask);
		}
		
		$ip_address_long = ip2long($ip_address);
		$ip_nmask_long = ip2long($mask);
		$ip_net = $ip_address_long & $ip_nmask_long;
		$ip_host_first = ((~$ip_nmask_long) & $ip_address_long);
		$ip_first = ($ip_address_long ^ $ip_host_first) + 1;
		$ip_broadcast_invert = ~$ip_nmask_long;
		$ip_last = ($ip_address_long | $ip_broadcast_invert) - 1;
		$ip_broadcast = $ip_address_long | $ip_broadcast_invert;
	    
		foreach (range($ip_first, $ip_last) as $ip)
		{
			array_push($hosts, long2ip($ip));
		}
	    
		$block_info = array(
			array("network" => long2ip($ip_net)),
			array("first_host" => long2ip($ip_first)),
			array("last_host" => long2ip($ip_last)),
			array("broadcast" => long2ip($ip_broadcast)),
			$hosts);
	    
		return $block_info;
	}
	
	private function excel ($FirstName, $LastName, $SamAccountName, $Company, $Department, $Title, $City, $StreetAddress)
	{		
	
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Request '. date('YmdHis'));
		$this->excel->getActiveSheet()->getStyle('A1:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1:I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('A1:I2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$this->excel->getActiveSheet()->getStyle('A3:M4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BDBDBD');
		$this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		
		
		
		$this->excel->getActiveSheet()->SetCellValue('A1', 'FirstName');
		$this->excel->getActiveSheet()->SetCellValue('B1', 'LastName');
		$this->excel->getActiveSheet()->SetCellValue('C1', 'SamAccountName');
		$this->excel->getActiveSheet()->SetCellValue('D1', 'Company');
		$this->excel->getActiveSheet()->SetCellValue('E1', 'Department');
		$this->excel->getActiveSheet()->SetCellValue('F1', 'Title');
		$this->excel->getActiveSheet()->SetCellValue('G1', 'City');
		$this->excel->getActiveSheet()->SetCellValue('H1', 'StreetAddress');
		$this->excel->getActiveSheet()->SetCellValue('I1', 'UserPassword');
		
		$this->excel->getActiveSheet()->SetCellValue('A2', $FirstName);
		$this->excel->getActiveSheet()->SetCellValue('B2', $LastName);
		$this->excel->getActiveSheet()->SetCellValue('C2', $SamAccountName);
		$this->excel->getActiveSheet()->SetCellValue('D2', $Company);
		$this->excel->getActiveSheet()->SetCellValue('E2', $Department);
		$this->excel->getActiveSheet()->SetCellValue('F2', $Title);
		$this->excel->getActiveSheet()->SetCellValue('G2', $City);
		$this->excel->getActiveSheet()->SetCellValue('H2', $StreetAddress);
		$this->excel->getActiveSheet()->SetCellValue('I2', '');
		
		$filename='request' . date('YmdHis') . '.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	public function text ()
	{
		$test = split('_', 'SZ_SPLIT_01_02_03', 3);
		$this->excel($test[0]."_".$test[1]."_", $test[2], 'SamAccountName', 'Company', 'Department', 'Title', 'City', 'StreetAddresscccc', 'UserPassword');
	}
}