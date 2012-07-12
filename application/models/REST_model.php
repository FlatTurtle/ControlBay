<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
abstract class REST_model extends CI_Model
{
    /*
     * table name
     */
    protected $_table;

    /*
     * table fields
     */
    protected $_fields;


    /*
     *  Validation method, has to be implemented on concrete class
     */
    abstract function isValid();

    /**
     * Insert a new row in the table
     *
     * @param $data associative array of field values
     * @return bool
     */
    function insert($data){
        if(!$this->isValid($data)){
            return false;
        }

        $this->db->insert($this->_table, $data);
    }

    /**
     * Get a row from the table using the primary key
     *
     * @param $id the rowId
     * @return mixed
     */
    function get($id){
        $this->db->where('id', $id);
        $result = $this->db->get($this->_table)->result();
        return $result;
    }

    /**
     * Get all rows of the table
     *
     * @return mixed
     */
    function get_all(){
        $result = $this->db->get($this->_table)->result();
        return $result;
    }

    /**
     * Update a row
     *
     * @param $id
     * @param $data
     * @return bool
     */
    function update($id, $data){
        if(!$this->isValid($data)){
            return false;
        }

        $this->db->where('id', $id);
        $this->db->update($data);
    }

    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->_table);
    }
}
