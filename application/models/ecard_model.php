<?php

/**
 * Ecard
 */
class Ecard_model extends MY_Model
{
    public $before_create = array( 'timestamps' );

    public function __construct()
    {
        parent::__construct();
    }

    protected function timestamps($book)
    {
        $book['created_at'] = $book['updated_at'] = date('Y-m-d H:i:s');
        return $book;
    }
}
