<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Erkanaauth_model extends CI_Model {

    var $db_table   = 'users';
    var $db_userid  = 'id';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        log_message('debug', 'Authorization class initialized (model Erkanaauth).');
    }


    /**
     * Attempt to login using the given condition
     *
     * Accepts an associative array as input, containing login conditions
     * Example:
     *     $conditions = array
     *     (
     *          'email'=>$email,
     *          'password'=>dohash($password)
     *     );
     *     $this->erkanaauth->try_login($conditions));
     *
     * @access public
     * @param  array login conditions
     * @return mixed boolean:false or object with user record
     */
    function try_login($condition = array())
    {
        $query = $this->db->get_where($this->db_table, $condition, 1, 0);

        if ($query->num_rows != 1) return FALSE;

        $row = $query->row();
        $this->session->set_userdata(array('user_id'=>$row->id));

        return $row;
    }

    /**
     * Multipurpose: Check logged state and have the current user info
     *
     * Copied from http://codeigniter.com/forums/viewthread/63423/P30/:
     * getUser() now returns a user's record and can be
     * used to determine login status as well as retrieving
     * user information. Right now it doesnt support roles
     * (so if you use that system, add in a JOIN to the method below)
     * but it will when I actually release this version
     *
     * @access public
     * @param  int the user id, defaults to session user_id
     * @return mixed boolean:false or object with user record
     */
    function getUser($id = FALSE)
    {
        if ($id == FALSE) $id = $this->session->userdata('user_id');

        if ($id == FALSE) return FALSE;

        $condition = array(($this->db_table .'.' .$this->db_userid) =>$id);

        $query = $this->db->get_where($this->db_table, $condition, 1, 0);

        $row = ($query->num_rows() == 1) ? $query->row() : FALSE;

        return $row;
        }

    /**
     * Logs a user out
     *
     * Example: $this->erkanaauth->logout()
     *
     * @access    public
     * @return    void
     */
     function logout()
    {
        $this->session->set_userdata(array('user_id'=>FALSE));
    }
 }

 ?>