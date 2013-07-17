<?php

class Yllapito extends CI_Controller
{
    private $user;
    public $card_count;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ecard_model', 'ecard');
        $this->load->model('user_model', 'users');
        $this->load->model('erkanaauth_model', 'erkana');

        $this->load->helper('date');
        $this->load->helper('form');

        $this->user = $this->erkana->getUser();

        if (!empty($this->user)) {
            $this->card_count = $this->ecard->countStatuses();
        }
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
            'count'         => $this->card_count,
            'messages'      => $this->session->flashdata('messages')
        );

        $this->load->view('_header', $data);
        $this->load->view('yllapito/dashboard', $data);
        $this->load->view('_footer', $data);
    }

    public function ecards($section = 'list')
    {
        if (empty($this->user)) {
            redirect("/yllapito/kirjaudu");
        }

        $data = array(
            'page_title'    => array( 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'frontpage' ),
            'user'          => $this->user,
            'count'         => $this->card_count,
            'messages'      => $this->session->flashdata('messages')
        );

        $page_title = array();

        switch ($section) {
            case 'save':
                $page       = 'yllapito/list_cards';
                $post       = $this->input->post();
                $from_page  = $this->input->post('from_page');
                $post       = $this->ecard->formatPost($post);

                $save = false;
                if (! empty($post)) {
                    $save = $this->ecard->saveCards($post);
                }

                if (empty($save)) {
                    $this->session->flashdata('message', 'Tallennus onnistui');
                    $this->session->keep_flashdata('message');
                    redirect($from_page);
                } else {
                    $this->session->flashdata('message', 'Tallennus epäonnistui');
                    $this->session->keep_flashdata('message');
                    redirect($from_page);
                }
                break;
            case 'queue':
                $page = "yllapito/list_cards";
                $page_title[] = "Jonossa";
                $page_classes = array('admin', 'ecards', 'queue');
                $limit = $section;
                break;
            case 'public':
                $page = "yllapito/list_cards";
                $page_title[] = "Julkisia";
                $page_classes = array('admin', 'ecards', 'public');
                $limit = $section;
                break;
            case 'private':
                $page = "yllapito/list_cards";
                $page_title[] = "Yksityisiä";
                $page_classes = array('admin', 'ecards', 'private');
                $limit = $section;
                break;
            case 'hidden':
                $page = "yllapito/list_cards";
                $page_title[] = "Piilotetut";
                $page_classes = array('admin', 'ecards', 'hidden');
                $limit = $section;
                break;
            default:
                $page = "yllapito/list_cards";
                $page_title[] = "Kaikki";
                $limit = null;
                $page_classes = array('admin', 'ecards', 'list_all');
                break;
        }

        if (empty($limit)) {
            $data['cards'] = $this->ecard->order_by('created_at')->get_all();
        } else {
            $data['cards'] = $this->ecard
                                        ->order_by('created_at')
                                        ->get_many_by('card_status', $limit);
        }

        $data['page_title'] = array_merge($page_title, $data['page_title']);

        $this->load->view('_header', $data);
        $this->load->view($page, $data);
        $this->load->view('_footer', $data);
    }

    public function users($action = 'listall', $user_id = null)
    {
        if (empty($this->user)) {
            redirect("/yllapito/kirjaudu");
        }

        $data = array(
            'page_title'    => array( 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'frontpage' ),
            'user'          => $this->user,
            'count'         => $this->card_count,
            'messages'      => $this->session->flashdata('messages')
        );
        $page_title = array();

        switch ($action) {
            case 'delete':
                $this->user->delete($user_id);
                redirect('yllapito/users');
                break;
            case 'save':
                $data = $this->input->post();
                $from = $data['from_page'];
                $this->users->save($user_id, $data);
                redirect($from);
                break;
            case 'show':
                $data['userid'] = $user_id;
                $data['userdata'] = $this->users->get($user_id);
                $page_title = array("Tiedot", "Käyttäjät");
                break;
            default:
                $data['users'] = $this->users->get_all();
                $page_title = array("Listaa kaikki", "Käyttäjät");
                break;
        }

        $data['page_title'] = array_merge($page_title, $data['page_title']);
        $page = 'yllapito/users_'.$action;

        $this->load->view('_header', $data);
        $this->load->view($page, $data);
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
            $pass = $this->users->passwordhash($pass);

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
        echo $this->users->passwordhash($password);
    }
}
