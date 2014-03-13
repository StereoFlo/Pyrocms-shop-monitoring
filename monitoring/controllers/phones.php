<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Phones extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('phones_m');
    }
    
    public function index ()
    {
        $this->template->title($this->module_details['name'])->build('frontend/phones/index', $this->data);
    }
    
    public function search ()
    {
        header('Content-Type: text/html; charset=utf-8');
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        if (strlen($q) > 2 and !empty($q))
        {
            $result = $this->phones_m->front_search($q);
            $this->data->search = isset($result) ? $result : 'nothing found';
        }
        else
        {
            $this->data->search = 'you need to input a work';
        }
        $this->load->view('frontend/phones/search', $this->data);
    }
}