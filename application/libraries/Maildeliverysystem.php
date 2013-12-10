<?php
/**
 * MailDeliverySystem Library
 *
 * @category Libraries
 * @package  Ecard
 * @author   Ismo Vuorinen <ismo@ivuorinen.net>
 * @license  http://choosealicense.com/licenses/agpl/ Affero GPL
 * @link     http://ystavakyla.fi
 */

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * We need Mandrill API Package to deliver email
 */
try {
    include_once APPPATH.'/third_party/Mandrill.php';
} catch (Exception $e) {
    log_message(
        'error',
        'MailDeliverySystem_Mandrill error: ' . $e->getMessage()
    );
}


/**
 * MailDeliverySystem library
 *
 * @category Libraries
 * @package  Ecard
 * @author   Ismo Vuorinen <ismo@ivuorinen.net>
 * @license  http://choosealicense.com/licenses/agpl/ Affero GPL
 * @link     http://ystavakyla.fi
 * @uses     Mandrill   Mandrill API Package
 */
class MailDeliverySystem
{
    /**
     * private codeigniter instance
     *
     * @var object
     */
    private $_ci;

    /**
     * @var $_receivers Mail receiver list, expects array with email and name
     */
    private $_receivers = array();

    /**
     * @var $_headers Mail Header details
     */
    private $_headers = array();

    public $sender_name  = 'Ystäväkylä';
    public $sender_email = 'noreply@ystavakyla.fi';
    public $bcc_address  = 'testaus@ivuorinen.net';

    /**
     * CONTENT VARIABLES
     */
    public $subject;
    public $content;

    /**
     * META VARIABLES
     */

    /**
     * $tags Contains tracking tags for mandrillapp.com
     * @var array
     */
    public $tags = array();

    /**
     * __construct initializes the library
     */
    public function __construct()
    {
        $this->_ci =& get_instance();
        log_message('debug', 'MailDeliverySystem: Loaded');

        /**
         * Set default reply-to address
         * @var array
         */
        $this->_headers = array(
            'Reply-To' => $this->sender_email
        );

        /**
         * Set default email receiver
         * @var array
         */
        $this->_receivers = array(
            array(
                'email' => 'testaus@ivuorinen.net',
                'name'  => 'Ismo Vuorinen'
            )
        );

        $this->tags = array(
            'ystavakyla'
        );
    }

    /**
     * sendMail
     * Everything needed to send email to receivers
     *
     * @param array  $receivers    Receivers array
     * @param string $content      Email HTML Content
     * @param string $subject      Email subject line
     * @param string $sender_name  Email sender name
     * @param string $sender_email Email sender email, doubles as reply to
     * @param array  $headers      Email headers, sets $this->_headers
     * @param array  $tags         Email tags for easier searching
     *
     * @return [type]            [description]
     */
    public function sendMail(
        $receivers      = null,
        $content        = null,
        $subject        = null,
        $sender_name    = null,
        $sender_email   = null,
        $headers        = null,
        $tags           = null
    ) {

        $this->sender_name  = $sender_name;
        $this->sender_email = $sender_email;

        $this->subject      = $subject;
        $this->content      = $content;

        $this->_receivers   = $receivers;
        $this->_headers     = $headers;

        if (! empty($tags)) {
            $this->tags     = $tags;
        }

        /**
         * Set up development mail address
         */
        if (ENVIRONMENT == 'development') {
            $this->sender_name = "Ystäväkylä Dev";
            $this->sender_email = "testaus@ivuorinen.net";

            $this->_headers = array(
              'Reply-To' => $this->sender_email
            );
        }


        /**
         * Try to send the email
         */
        try {
            $mandrill = new Mandrill(MAILCHIMP_API_KEY);
            $message  = $this->buildMessage();

            $async    = false;
            $ip_pool  = 'Main Pool';
            $send_at  = null;

            $result   = $mandrill->messages->send(
                $message,
                $async,
                $ip_pool,
                $send_at
            );

            log_message('debug', serialize($result));

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            $msg = 'A mandrill error occurred: '
                . get_class($e)
                . ' - '
                . $e->getMessage();
            // A mandrill error occurred:
            //  Mandrill_Unknown_Subaccount -
            //  No subaccount exists with the id 'customer-123'
            log_message('error', $msg);
            // throw $e;
        }

    }

    /**
     * buildMessage
     * Return message variables for sendMail() method
     *
     * @return array Message variables for sendMail();
     */
    public function buildMessage()
    {
        $tracking_domain = getEmailDomain($this->sender_email);

        $message  = array(
            'html'                => $this->content, // ci view
            'subject'             => $this->subject,
            'from_email'          => $this->sender_email,
            'from_name'           => $this->sender_name,
            'to'                  => $this->_receivers,
            'headers'             => $this->_headers,
            'important'           => false,
            'track_opens'         => true,
            'track_clicks'        => true,
            'auto_text'           => true,
            'auto_html'           => null,
            'inline_css'          => null,
            'url_strip_qs'        => null,
            'preserve_recipients' => null,
            'view_content_link'   => null,
            'bcc_address'         => $this->sender_email,
            'tracking_domain'     => $tracking_domain,
            'signing_domain'      => $tracking_domain,
            'return_path_domain'  => $tracking_domain,
            'merge'               => false,
            'global_merge_vars'   => null,
            'tags'                => $this->tags,
            'subaccount'          => null
        );

        return $message;
    }

}