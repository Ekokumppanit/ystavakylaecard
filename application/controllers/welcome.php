<?php

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ecard_model', 'ecard');
    }

    public function index()
    {

        $data = array(
            'page_title'    => array( 'Etusivu', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'frontpage' )
        );

        $this->load->view('_header', $data);
        $this->load->view('welcome_message', $data);
        $this->load->view('_footer', $data);
    }

    public function info()
    {
        $data = array(
            'page_title'    => array( 'Tietoa', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'info' )
        );

        $this->load->view('_header', $data);
        $this->load->view('info', $data);
        $this->load->view('_footer', $data);
    }

    public function newCard()
    {

        $data = array(
            'page_title'    => array( 'Uusi eKortti', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'new_card' ),

            'images'        => array(
                                "http://placekitten.com/800/550",
                                "http://placekitten.com/g/800/550",
                                "http://placekitten.com/800/551",
                                "http://placekitten.com/g/800/551",
                                "http://placekitten.com/800/552",
                                "http://placekitten.com/g/800/552"
            )
        );

        $this->load->view('_header', $data);
        $this->load->view('new', $data);
        $this->load->view('_footer', $data);
    }

    public function ecards($card_id = null)
    {
        $data = array(
            'page_classes' => array( 'ecards' )
        );

        if (empty($card_id)) {
            $data['ecards'] = $this->ecard->get_all();
            $data['page_title'] = array( 'Listaa kaikki kortit', 'Ystäväkylä eKortti' );
            $data['page_classes'][] = 'show_all';

            $this->load->view('_header', $data);
            $this->load->view('show_all', $data);
            $this->load->view('_footer', $data);

        } else {

            if (strlen($card_id) != 32) {
                redirect("ecards");
            }

            $data['ecard'] = $this->ecard->get_by('hash', $card_id);
            $data['page_title'] = array( 'eKortti', 'Ystäväkylä eKortti' );

            if (empty($data['ecard'])) {
                $data['ecard'] = new stdClass();
                $data['ecard']->id              = $card_id;
                $data['ecard']->response        = "error";
                $data['ecard']->response_text   = "No card found with that id";
            }

            $data['page_classes'][] = 'show_one';

            $this->load->view('_header', $data);
            $this->load->view('show_one', $data);
            $this->load->view('_footer', $data);

        }

    }

    public function upload()
    {
        # code...
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
