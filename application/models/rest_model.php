<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
abstract class REST_Model extends CI_Model
{
    /*
     * Table name
     */
    protected $_table;

    /*
     * Optional validation rules
     */
    protected $_validation_rules = array();

    /**
     * Filter columns that are not allowed to be changed
     *
     * @abstract
     * @param $data
     * @return mixed
     */
    abstract function filter($data);

    /**
     * Insert a new row in the table
     *
     * @param $data associative array of field values
     * @throws ErrorException : if a database error occurs
     * @return id of insert
     */
    function insert($data){
        if(!$this->isValid($data)){
            return false;
        }

        $this->db->insert($this->_table, $data);
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());

        return $this->db->insert_id();
    }

    /**
     * Get a row from the table using the primary key
     *
     * @param $id
     * @return mixed
     * @throws ErrorException : if a database error occurs
     */
    function get($id){
        $this->db->where('id', $id);
        $result = $this->db->get($this->_table);
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $result->result();
    }

    /**
     * Get all rows of the table
     *
     * @return mixed
     * @throws ErrorException : if a database error occurs
     */
    function get_all(){
        $result = $this->db->get($this->_table)->result();
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $result;
    }

    /**
     * Update a row
     *
     * @param $id
     * @param $data
     * @throws ErrorException : if a database error occurs
     */
    function update($id, $data){
        if(!is_array($data) || !$this->isValid($data) ){
            throw new ErrorException(ERROR_DATA_NOT_VALID);
        }

        $data = $this->filter($data);

        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
    }

    /**
     * Remove a row from the table
     *
     * @param $id
     * @throws ErrorException : if a database error occurs
     */
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->_table);
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
    }

    /**
     * Get the number of rows in the table
     *
     * @return int : the number of rows in the table
     */
    public function count(){
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    /**
     * Validate data
     *
     * @param $data :row data
     * @return bool
     */
    function isValid($data)
    {
        if(empty($this->_validation_rules))
            return true;

        foreach ($data as $key => $val) {
            $_POST[$key] = $val;
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules($this->_validation_rules);
        return $this->form_validation->run();
    }
}
