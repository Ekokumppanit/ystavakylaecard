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

    public function add($data)
    {
        if (empty($data)) {
            return false;
        }

        unset(
            $data['password_again'],
            $data['savedata'],
            $data['submit']
        );
        $data['password'] = $this->passwordhash($data['password']);

        return $this->insert($data);
    }

    public function save($uid = null, $data = null)
    {
        if (empty($uid) || empty($data)) {
            return false;
        }

        unset(
            $data['from_page'],
            $data['savedata'],
            $data['submit']
        );

        return $this->update($uid, $data);
    }

    public function savePassword($uid = null, $password = null)
    {
        if (empty($uid) || empty($password)) {
            return false;
        }

        $password = $this->passwordhash($password);
        return $this->update($uid, array('password' => $password));
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
