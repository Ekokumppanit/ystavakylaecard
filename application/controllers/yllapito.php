<?php

class Yllapito extends CI_Controller
{
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ecard_model', 'ecard');
        $this->load->model('erkanaauth_model', 'erkana');

        $this->user = $this->erkana->getUser();
    }

    public function index()
    {
        if (empty($this->user)) {
            redirect("/yllapito/kirjaudu");
        }

        $data = array(
            'page_title'    => array( 'Etusivu', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'frontpage' ),
            'user'          => $this->user,
            'messages'      => $this->session->flashdata('messages')
        );

        $this->load->view('_header', $data);
        $this->load->view('yllapito/dashboard', $data);
        $this->load->view('_footer', $data);
    }

    public function kirjaudu()
    {
        // POST
        $login = $this->input->post();
        if ($login) {
            $user = $this->input->post('username');
            $pass = $this->input->post('password');

            // Hash the password
            $pass = $this->passwordhash($pass);

            $test = array(
                'username'      => $user,
                'password'      => $pass // Hashed password
            );
            $this->erkana->try_login($test);

            if (($user = $this->erkana->getUser())) {
                $this->db->update(
                    'users',
                    array(
                        'last_login' => date("Y-m-d H:i:s")
                    ),
                    "id = ". $user->id
                );
                redirect("yllapito");
            } else {
                $this->session->set_flashdata(
                    'error',
                    'Kirjautuminen epäonnistui'
                );
                redirect("yllapito/kirjaudu");
            }
        }

        // GET
        if (! empty($this->user)) {
            redirect("yllapito");
        }

        $data = array(
            'page_title'    => array( 'Kirjaudu', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'login' ),
            'user'          => $this->user,
            'error'         => $this->session->flashdata('error')
        );

        $this->load->view('_header', $data);
        $this->load->view('yllapito/login', $data);
        $this->load->view('_footer', $data);
    }


    public function logout()
    {
        $this->erkana->logout();
        redirect("yllapito");
    }

    public function makePassword($password = null)
    {
        echo $this->passwordhash($password);
    }



    private function passwordhash($password = null)
    {
        return hash(
            'ripemd160',
            $password . $this->config->item('encryption_key')
        );
    }
}
