<?php

  class Model
  {
    protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames = [];
    public $id;

    public function __construct($table)
    {
      $this->_db = Database::getInstance();
      $this->_table = $table;
      $this->_setTableColumns();
      $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));

    }

    /**
     * Set table columns on database
     * @uses get
     */
    protected function _setTableColumns()
    {
      $columns = $this->_get_columns();
      if ($columns) {
        foreach ($columns as $column)
        {
          $columnName = $column->Field;
          $this->_columnNames [] = $column->Field;
          $this->{$columnName} = null;
        }
      }
    }

    /**
     * Returns the list of columns of a table
     */
    public function _get_columns()
    {
      return $this->_db->get_columns($this->_table);
    }

    /**
     * Returns a list of condition params
     * @param params
     */
    public function find($params = [])
    {
      $results = [];
      $resultQuery = $this->_db->find($this->_table, $params);
      if ($resultQuery)
      {
        foreach ($resultQuery as $result)
        {
          $results [] = $result;
        }
        return $results;
      }
      return false;
    }

    /**
     * Returns  the data of the specified params
     *
     * @param mixed $table
     * @param mixed $params
     * @return void
     */
    public function findIn($table, $params = [])
    {
      $results = [];
      $resultQuery = $this->_db->find($table, $params);
      if ($resultQuery) {
        foreach ($resultQuery as $result)
        {
          $results [] = $result;
        }
        return $results;
      }
    }

    /**
     * Returns the first element of an array
     *
     * @param mixed $params
     * @return void
     */
    public function findFirst($params = [])
    {
      return $this->_db->find($this->_table, $params);
    }

    /**
     * Find an element by ID
     *
     * @param mixed $id
     * @return void
     */
    public function findById($id)
    {
      return $this->findFirst(['conditions' => "id = ?", 'bind' => [$id]]);
    }

    /**
     * Detects to Save or Update
     *
     * @return void
     */
    public function save()
    {
      $fields = [];
      foreach ($this->_columnNames as $column)
      {
        $fields [$column] = $this->column;
      }
      if (property_exists($this, 'id') && $this->id != '')
      {
        return $this->update($this->id, $fields);
      } else
      {
        return $this->create($fields);
      }
    }

    public function create($fields)
    {
      if (empty($fields)) return false;
      return $this->_db->create($this->_table, $fields);
    }

    public function createIn($table, $fields)
    {
      if (empty($fields)) return false;
      return $this->_db->create($table, $fields);
    }

    public function update($id, $fields)
    {
      if (empty($fields) || $id == '') return false;
      return $this->_db->update($this->_table, $id, $fields);
    }

    public function delete($id)
    {
      if ($id == '') return false;
      return $this->_db->delete($this->_table, $id);
    }

    public function _delete($id, $table)
    {
      if ($id == '') return false;
      return $this->_db->delete($table, $id);
    }

    public function query($sql, $bind = [])
    {
      return $this->_db->query($sql, $bind);
    }

    public function data()
    {
      $data = new stdClass();
      foreach ($this->_columnNames as $column)
      {
        $data->column = $this->column;
      }
      return $data;
    }

    public function assign($params)
    {
      if (!empty($params))
      {
        foreach ($params as $key => $val)
        {
          if (in_array($key, $this->_columnNames))
          {
            $this->key = sanitize($val);
          }
        }
        return true;
      }
      return false;
    }

    public function populateObjData($result)
    {
      foreach ($result as $key => $val)
      {
        $this->$key = $val;
      }
    }

    public function count()
    {
      return $this->_db->query("SELECT COUNT(*) FROM {$this->_table}")->results();
    }

    public function _count($table)
    {
      return $this->_db->query("SELECT COUNT(*) FROM {$table}")->results();
    }
  }
