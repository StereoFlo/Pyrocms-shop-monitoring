<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Phones_m extends MY_Model {

	private $table;
        private $pools_table;
	public function __construct()
	{
		parent::__construct();
		$this->table = 'monitoring_phones';
                $this->pools_table = 'monitoring_phone_pools';
	}
        
	public function get_phones($num, $offset)
	{
		return $this->db->get($this->table, $num, $offset)->result();
	}
	
	public function get_phones_free ($pool_id)
	{
		$this->db->where('pool_id', $pool_id);
		$this->db->where('shop_id IS NULL');
		$this->db->order_by('phone', 'ASC');
		return $this->db->get($this->table)->result();
	}
	
	public function get_pool_id ($phone)
	{
		$this->db->where('id', $phone);
		return $this->db->get($this->table)->row();
	}
	
	public function get_phone ($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table)->result();
	}
        
	public function get_phones_by_pool ($id)
	{
		$this->db->where('pool_id', $id);
		$this->db->order_by('phone', 'ASC');
		return $this->db->get($this->table)->result();
	}
	
	public function seach_phones_by_pool ($id, $phone)
	{
		$this->db->where('pool_id', $id);
		$this->db->like('phone', $phone);
		$this->db->order_by('phone', 'ASC');
		return $this->db->get($this->table)->result();
	}

	public function get_phone_by_shop ($id)
	{
		$this->db->where('shop_id', $id);
		return $this->db->get($this->table)->row();
	}
	
	public function add_phone ($input)
	{
	    $this->db->set('pool_id', $input['pool_id']);
            $this->db->set('shop_id', $input['shop_id']);
	    $this->db->set('phone', $input['phone']);
	    return $this->db->insert($this->table);
	}
	
	function update_phone ($input)
	{
            $this->db->set('shop_id', $input['shop_id']);
            $this->db->where('id', $input['phone']);
	    return $this->db->update($this->table);
	}

	function update_phone_by_shop ($input)
	{
            $this->db->set('shop_id', $input['shop_id']);
            $this->db->where('shop_id', $input['shop_id']);
	    return $this->db->update($this->table);
	}
	
	public function check_phone ($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get($this->table)->num_rows();
	}
	
	public function delete_phones ($id)
	{
		$this->db->where('pool_id', $id);
		return $this->db->delete($this->table);
	}

	//
	//
	//	Pools
	//
	//
	
        public function add_pool ($input)
	{
		$this->db->set('name', $input['name']);
		$this->db->set('start', $input['start']);
		$this->db->set('end', $input['end']);
		$this->db->insert($this->pools_table);
		return $this->db->insert_id();
	}
	
	public function get_pools ()
	{
		return $this->db->get($this->pools_table)->result();
	}
	
	public function delete_pool ($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->pools_table);
		$this->db->where('pool_id', $id);
		$this->db->delete($this->table);
	}
	
	public function front_search ($query)
	{
		$this->db->select('monitoring_shops.id, monitoring_shops.name, monitoring_phones.phone');
		$this->db->from('monitoring_phones');
		$this->db->join('monitoring_shops', 'monitoring_phones.shop_id = monitoring_shops.id');
		$this->db->like('monitoring_shops.name', $query);
		$this->db->or_like('monitoring_phones.phone', $query);
		return $this->db->get()->result();
	}

}