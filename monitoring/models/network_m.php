<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Network_m extends MY_Model {

	private $shop_table;
	public function __construct()
	{
		parent::__construct();
		$this->shop_table = 'monitoring_networks';
	}
	
	public function get_networks ($num, $offset)
	{
		return $this->db->get($this->shop_table, $num, $offset)->result();
	}
	
	public function get_network ($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->shop_table)->result();
	}

	public function get_network_by_shop ($id)
	{
		$this->db->where('shop_id', $id);
		return $this->db->get($this->shop_table)->result();
	}
	
	public function get_networks_count ()
	{
		return $this->db->get($this->shop_table)->num_rows();
	}

	function update_network ($input)
	{
	    $this->db->set('provider_id', $input['provider']);
	    $this->db->set('shop_id', $input['shop']);
	    $this->db->set('ip', $input['ip']);
            $this->db->set('mask', $input['mask']);
            $this->db->set('gate', $input['gate']);
	    $this->db->set('type', $input['type']);
	    return $this->db->update($this->shop_table);
	}
	public function delete_network ($id)
	{
	    $this->db->where('id', $id);
	    $this->db->delete($this->shop_table);
	}
	
	public function delete_network_by_shop ($id)
	{
	    $this->db->where('shop_id', $id);
	    $this->db->delete($this->shop_table);
	}
	
	public function add_network ($input)
	{
	    $this->db->set('provider_id', $input['provider']);
	    $this->db->set('shop_id', $input['shop']);
	    $this->db->set('ip', $input['ip']);
            $this->db->set('mask', $input['mask']);
            $this->db->set('gate', $input['gate']);
	    $this->db->set('type', $input['type']);
            $this->db->set('speed', $input['speed']);
	    $this->db->set('comment', $input['comment']);
	    $this->db->insert($this->shop_table);
	}
	
	public function check_network ($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get($this->shop_table)->num_rows();
	}
	
	public function check_ip ($ip)
	{
	    $this->db->where('ip', $ip);
	    return $this->db->get('monitoring_local_networks')->num_rows();
	}	
	
	public function add_ip ($shop, $ip, $host, $state)
	{
	    $this->db->set('shop_id', $shop);
	    $this->db->set('ip', $ip);
	    $this->db->set('host', $host);
	    $this->db->set('state', $state);
	    $this->db->insert('monitoring_local_networks');
	}
	
	public function get_ip ($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get('monitoring_local_networks')->result();
	}

	public function update_ip ($id, $type)
	{
	    $this->db->where('id', $id);
	    $this->db->set('type', $type);
	    return $this->db->update('monitoring_local_networks');
	}
	
	public function get_ips ($shop)
	{
	    $this->db->order_by('id', 'ASC');
	    $this->db->where('shop_id', $shop);
	    return $this->db->get('monitoring_local_networks')->result();
	}
	
	public function update_state_ip ($ip, $state, $host)
	{
		$this->db->where('id', $ip);
		$this->db->set('state', $state);
		$this->db->set('host', $host);
		$this->db->update('monitoring_local_networks');
	}
	
	public function delete_ips ($shop)
	{
	    $this->db->where('shop_id', $shop);
	    return $this->db->delete('monitoring_local_networks');
	}
	
	
	public function get_types ()
	{
	    return $this->db->get('monitoring_device_types')->result();
	}
	public function get_type ($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get('monitoring_device_types')->row();
	}
}
