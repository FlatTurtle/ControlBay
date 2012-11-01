<?php
/*
 * Extend input helper with PUT and DELETE
 */

class Extended_Input extends CI_Input {

    var $delete;
    var $put;

    function Extended_Input() {
        parent::__construct();

        if ($this->server('REQUEST_METHOD') == 'DELETE') {
            parse_str(file_get_contents('php://input'), $this->delete);

            $this->delete = $this->_clean_input_data($this->delete);
        } elseif ($this->server('REQUEST_METHOD') == 'PUT') {
            parse_str(file_get_contents('php://input'), $this->put);

            $this->put = $this->_clean_input_data($this->put);
        }
    }

    function delete($index = '', $xss_clean = FALSE) {
		if(!empty($index))
			return $this->_fetch_from_array($this->delete, $index, $xss_clean);
		else
			return $this->delete;
    }

    function put($index = '', $xss_clean = FALSE) {
		if(!empty($index))
	        return $this->_fetch_from_array($this->put, $index, $xss_clean);
		else
			return $this->put;
    }

}
?>