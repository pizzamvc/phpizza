<?php

/**
 * Common query builders for insert, update, delete etc. for MySQL-based DB Drivers.
 * \note For internal use of the PHPizza framework only! Don't rely on this class unless you understand what you're doing.
 */
abstract class DbMysql_query_builder extends DbGeneric {

    public $dbengine;       ///< Probably "mysql" or "pdo" etc.

    /**
     * Generates Query for insertArray()
     * @param type $columnToEncrypt
     * @param type $valueToEncrypt 
     */

    public function insertArrayQuery() {
        $fields = $values = array();

        foreach ($this->data as $key => $val) {
            $fields[] = '`' . $key . '`';
            $values[] = '\'' . mysql_real_escape_string($val) . '\'';
        }

        if ($this->encryptedData) {
            foreach ($this->encryptedData as $key => $val) {
                $fields[] = '`' . $key . '`';
                $values[] = $this->encryptionFunction . '(\'' . mysql_real_escape_string($val) . '\')';
            }
        }

        $fields = implode(",", $fields);
        $values = implode(",", $values);

        $this->query = 'INSERT INTO `' . $this->table . '` (' . $fields . ') VALUES (' . $values . ')';
    }

    /**
     * Generates query for updateArray()
     */
    public function updateArrayQuery() {
        $fields = $values = array();
        $this->query = 'UPDATE `' . $this->table . '` SET ';

        foreach ($this->data as $key=>$val) {
            $this->query .= '`' . $key . '` = ';
            $this->query .= '\'' . mysql_real_escape_string($val) . '\', ';
        }

        if ($this->encryptedData) {
            foreach ($this->encryptedData as $key => $val) {
                $this->query .= '`' . $key . '` = ';
                $this->query .= $this->encryptionFunction . '(\'' . mysql_real_escape_string($val) . '\')';
            }
        }

        $this->query = substr($this->query, 0, strlen($this->query) - 2);

        if ($this->identifier) {
            $this->query .= ' WHERE ';
            $where = array();
            foreach ($this->identifier as $k => $v) {
                $where[] = '`$k` = \'' . mysql_real_escape_string($v) . '\'';
            }
            $this->query .= implode(' ' . $this->joiner . ' ', $where);
        }

        $this->query .= ' ' . $this->rest;
    }

    /**
     * Generates query for selectArray()
     */
    public function selectArrayQuery() {
        $this->query = 'SELECT ';
        if (!$this->select) {
            $this->query .= '*';
        } else {
            $this->query .= implode($this->select, ', ');
        }
        if (is_array($this->table)) {
            $tables = implode(', ', $this->table);
            $this->query .= ' FROM ' . $tables;
        } else {
            $this->query .= " FROM `" . $this->table . "`";
        }

        if ($this->identifier) {
            $this->query .= ' WHERE ';
            $partialQuery = '';
            foreach ($this->identifier as $key => $i) {
                $partialQuery[] = $key . ' = \'' . mysql_real_escape_string($i) . '\'';
            }
            $this->query .= implode($partialQuery, ' ' . $this->joiner . ' ');
        }

        if ($this->tableJoinIdentifier) {
            if ($this->identifier) {
                $this->query .= ' ' . $this->joiner . ' ';
            } else {
                $this->query .= ' WHERE ';
            }
            $partialQuery = '';
            foreach ($this->tableJoinIdentifier as $key => $i) {
                $partialQuery[] = $key . ' = ' . mysql_real_escape_string($i) . '';
            }
            $this->query .= implode($partialQuery, ' ' . $this->joiner . ' ');
        }
        if ($this->rest)
            $this->query .= ' ' . $this->rest;
    }

    /**
     * Generate query delete()
     */
    public function deleteQuery() {
        $this->query = 'DELETE FROM `' . $this->table . '` WHERE';
        $where = array();
        foreach ($this->identifier as $k => $v) {
            $where[] = '`' . $k . '` = \'' . mysql_real_escape_string($v) . '\'';
        }
        $this->query .= implode($this->joiner, $where) . $this->rest;
    }

    /**
     * @name Functions for Internal use
     */
    //@{
    //@}
}

?>
