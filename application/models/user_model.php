<?php

/**
 * User model that we use to control our users
 */
class User_model extends MY_Model
{
    public $before_create = array( 'timestamps' );

    public function __construct()
    {
        parent::__construct();
    }

    public function passwordhash($password = null)
    {
        return hash(
            'ripemd160',
            $password . $this->config->item('encryption_key')
        );
    }

    protected function timestamps($ecard)
    {
        $ecard['created_at'] = $ecard['updated_at'] = date('Y-m-d H:i:s');
        return $ecard;
    }
}
