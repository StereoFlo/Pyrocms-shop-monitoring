<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring_m extends MY_Model {

	private $shop_table;
	public function __construct()
	{
		parent::__construct();
		$this->shop_table = 'monitoring_shops';
	}
	
	public function get_shops ($num = null, $offset= null)
	{
		if (is_null($num) and is_null($offset))
		{
			return $this->db->get($this->shop_table)->result();
		}
		else
		{
			return $this->db->get($this->shop_table, $num, $offset)->result();
		}
	}
	public function search_shops ($search)
	{
		$this->db->like('code', $search);
		$this->db->or_like('name', $search);
		$this->db->or_like('address', $search);
		return $this->db->get($this->shop_table)->result();
	}
	
	public function get_shop ($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->shop_table)->result();
	}
	
	public function get_shops_count ()
	{
		return $this->db->get($this->shop_table)->num_rows();
	}

	function update_shop ($input)
	{
	    $this->db->set('code', $input['code']);
	    $this->db->set('name', $input['name']);
	    $this->db->set('address', $input['address']);
	    $this->db->set('state', $input['state']);
	    $this->db->set('region_id', $input['region']);
	    $this->db->where('id', $input['id']);
	    return $this->db->update($this->shop_table);
	}
	public function delete_shop ($id)
	{
	    $this->db->where('id', $id);
	    $this->db->delete($this->shop_table);
	}
	public function add_shop ($input)
	{
	    $this->db->set('code', $input['code']);
	    $this->db->set('name', $input['name']);
	    $this->db->set('address', $input['address']);
	    $this->db->set('state', $input['state']);
	    $this->db->set('region_id', $input['region']);
	    $this->db->set('tmode', $input['tmode']);
	    $this->db->insert($this->shop_table);
	    return $this->db->insert_id();
	}
	public function check_shop ($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get($this->shop_table)->num_rows();
	}
	
	public function get_networks_by_provider ($id)
	{
		$this->db->where('provider_id', $id);
		return $this->db->get('monitoring_networks')->result();
	}
	public function get_provider_by_shop ($id)
	{
		$this->db->where('shop_id', $id);
		return $this->db->get('monitoring_networks')->result();
	}
	
	public function notice_save ($data)
	{
	    $this->db->set('notice_id', $data['notice_id']);
	    $this->db->set('shop_id', $data['shop_id']);
	    $this->db->set('subject', $data['subject']);
	    $this->db->set('comment', $data['comment']);
	    $this->db->set('email', $data['email']);
	    $this->db->insert('monitoring_notice');
	    return $this->db->insert_id();
	}
	
	public function notice_get_by_shop ($shop_id)
	{
		$this->db->order_by('id', 'DESC');
		$this->db->where('shop_id', $shop_id);
		$this->db->limit(5);
		return $this->db->get('monitoring_notice')->result();
	}
	
	public function delete_notices_by_shop ($shop_id)
	{
		$this->db->where('shop_id', $shop_id);
		$this->db->delete('monitoring_notice');
	}
	
	public function get_filials ()
	{
		return $this->db->get('monitoring_filials')->result();
	}

	public function get_regions ()
	{
		return $this->db->get('monitoring_regions')->result();
	}
	
	public function get_region ($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('monitoring_regions')->result();
	}
}
