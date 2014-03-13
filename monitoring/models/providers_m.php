<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Providers_m extends MY_Model {

	private $table;
	public function __construct()
	{
		parent::__construct();
		$this->table = 'monitoring_providers';
	}
        
	public function get_providers ()
	{
		return array($this->db->get($this->table)->result(), $this->db->get($this->table)->num_rows());
	}
	
	public function search_provider ($search)
	{
		$this->db->like('name', $search);
		$this->db->or_like('dogovor', $search);
		$this->db->or_like('manager_phone', $search);
		$this->db->or_like('tech_phone', $search);
		$this->db->or_like('comment', $search);
		return array($this->db->get($this->table)->result(), $this->db->get($this->table)->num_rows());
	}
	
	public function get_provider ($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table)->result();
	}

	function update_provider ($input)
	{
	    $this->db->set('name', $input['name']);
	    $this->db->set('dogovor', $input['dogovor']);
	    $this->db->set('manager_phone', $input['manager_phone']);
	    $this->db->set('tech_phone', $input['tech_phone']);
            $this->db->set('comment', $input['comment']);
            $this->db->set('date', 'NOW()', FALSE);
	    $this->db->where('id', $input['id']);
	    return $this->db->update($this->table);
	}
	public function delete_provider ($id)
	{
	    $this->db->where('id', $id);
	    $this->db->delete($this->table);
	}
	public function add_provider ($input)
	{
	    $this->db->set('name', $input['name']);
	    $this->db->set('dogovor', $input['dogovor']);
	    $this->db->set('manager_phone', $input['manager_phone']);
	    $this->db->set('tech_phone', $input['tech_phone']);
            $this->db->set('comment', $input['comment']);
            $this->db->set('date', 'NOW()', FALSE);
	    $this->db->insert($this->table);
	}
	public function check_provider ($id)
	{
	    $this->db->where('id', $id);
	    return $this->db->get($this->table)->num_rows();
	}
}