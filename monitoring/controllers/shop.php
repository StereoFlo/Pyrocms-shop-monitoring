<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends Public_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('phones_m');
        $this->load->model('monitoring_m');
    }
    
    public function index ()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : NULL;
        header('Content-Type: text/html; charset=utf-8');
        if (!is_null($id))
        {
            $this->data->shop = $this->monitoring_m->get_shop($id);
            $this->load->view('frontend/shop/index', $this->data);
        }
        else
        {
            show_404();
        }
        
    }
}