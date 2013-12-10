<?php

class Welcome extends CI_Controller
{
    private $_user;
    public $card_count;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ecard_model', 'ecard');
        $this->load->model('erkanaauth_model', 'erkana');

        $this->_user = $this->erkana->getUser();
        $this->card_count = $this->ecard->countStatuses();
    }

    public function index()
    {

        $data = array(
            'page_title'    => array( 'Etusivu', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'frontpage' ),
            'count'         => $this->card_count,
            'user'          => $this->_user
        );

        $this->load->view('_header', $data);
        $this->load->view('welcome_message', $data);
        $this->load->view('_footer', $data);
    }

    public function error404()
    {
        $data = array(
            'page_title'    => array( 'Virhe 404: Sivua ei löydetty', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'error404' ),
            'count'         => $this->card_count,
            'user'          => $this->_user
        );

        $this->load->view('_header', $data);
        $this->load->view('error404', $data);
        $this->load->view('_footer', $data);
    }

    public function info()
    {
        $data = array(
            'page_title'    => array( 'Tietoa', 'Ystäväkylä eKortti' ),
            'page_classes'  => array( 'info' ),
            'count'         => $this->card_count,
            'user'          => $this->_user
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
            'count'         => $this->card_count,
            'images'        => $this->ecard->getCardsTemplates(1),
            'user'          => $this->_user
        );

        $this->load->view('_header', $data);
        $this->load->view('new', $data);
        $this->load->view('_footer', $data);
    }

    public function ecards($card_id = null)
    {
        $data = array(
            'page_classes'  => array( 'ecards' ),
            'count'         => $this->card_count,
            'user'          => $this->_user
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
            } else {
                $data['ecard']->response        = 200;
            }

            $data['page_classes'][] = 'show_one';

            $this->load->view('_header', $data);
            $this->load->view('show_one', $data);
            $this->load->view('_footer', $data);

        }

        return false;
    }

    public function preview($urldata = null)
    {
        if (empty($urldata)) {
            return false;
        }

        $data = array();
        $rawdata = explode(",", urldecode($urldata));
        foreach ($rawdata as $dataline) {
            list($key, $value) = explode("=", $dataline);

            $value = str_replace(";-;", "\r", $value);
            $value = str_replace(";:;", "\n", $value);
            $data[$key] = urldecode($value);
        }

        $opts  = parseImageOptions($data);

        $imgresource = $this->ecard->createCard(
            $opts['cardPath'],
            $opts['cardHead'],
            $opts['cardText'],
            $opts['cardHeadPlace'],
            $opts['cardTextPlace'],
            $opts['cardHeadSize'],
            $opts['cardTextSize'],
            $opts['cardSize']
        );

        $this->ecard->showCard($imgresource);
    }

    public function saveCard()
    {
        $image = $this->input->post();

        if (empty($image)) {
            redirect("uusi");
        }

        $opts  = parseImageOptions($image);
        $entry = parseCardEntryValues($image);

        $imgresource = $this->ecard->createCard(
            $opts['cardPath'],
            $opts['cardHead'],
            $opts['cardText'],
            $opts['cardHeadPlace'],
            $opts['cardTextPlace'],
            $opts['cardHeadSize'],
            $opts['cardTextSize'],
            $opts['cardSize']
        );

        if (empty($imgresource)) {
            $this->session->flash_data('message', 'Virhe luodessa kuvaa');
            redirect("uusi");
        }

        if (empty($entry)) {
            $this->session->flash_data('message', 'Virhe tiedoissa');
            redirect("uusi");
        }

        if ($this->ecard->get_by('hash', $entry['hash'])) {
            redirect("ecards/" . $entry['hash']);
        }

        if (($card = $this->ecard->savecard($imgresource, $entry['hash']))) {

            if ($card != $entry['hash']) {
                log_message('debug', "card: {$card} != hash: {$entry['hash']}");
            }

            $this->ecard->insert($entry);

            redirect(site_url('ecards/' . $entry['hash']));
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
