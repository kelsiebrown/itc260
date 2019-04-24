<?php
//application/controllers/News.php

class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->config->set_item('banner', 'News Section');
        $this->load->model('news_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $this->config->set_item('title', 'Seattle Sports News');  // set the actual title tag
        $nav1 = $this->config->item('nav1');
        $data['news'] = $this->news_model->get_news();
        $data['title'] = 'News archive';   // body heading - not a true title
        $this->load->view('news/index', $data);
    }

    public function view($slug = NULL)
    {   
        // slug without dashes
        $dashless_slug = str_replace("-", " ", $slug);
        
        // uppercase slug words
        $dashless_slug = ucwords($dashless_slug);
        
        // use dashless slug for title
        $this->config->set_item('title', 'NEWSFLASH! ' . $dashless_slug);
        
        $data['news_item'] = $this->news_model->get_news($slug);
        if (empty($data['news_item']))
        {
            show_404();
        }

        $data['title'] = $data['news_item']['title'];
        $this->load->view('news/view', $data);
    }
    
    public function create(){
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a news item';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('news/create');
            $this->load->view('templates/footer');

        }
        else {
            //$this->news_model->set_news();
            //$this->load->view('news/success');
            
            $slug = $this->news_model->set_news();
            
            if ($slug!==false){
                feedback('Data entered successfully.', 'info');
                redirect('news/view/' . $slug);   // slug sent
            } else {
                feedback('Error - no data entered.', 'error');
                redirect('news/create');   // error
            }
        }
    }

}

?>