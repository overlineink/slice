<?php

	class Database
	{

		/**
		 * @static global helpers for singleton
		 */
		private static $_instance;
		// Private helpers
		private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;

		private function __construct()
		{
			try {
				// tring to connect database
				$this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD);
			} catch (PDOException $e) {
				// Display error message
				die("Oops! We can't access database, see the errors bellow \n" . $e->getMessage());
			}
		}

		/** @static function that returns an instance of @uses Database */
		public static function getInstance()
		{
			if (!isset(self::$_instance))
			{
				/** Making new instance of @uses Database */
				self::$_instance = new Database();
			}
			return self::$_instance;
		}

		/** @method Responsable for database instructions
		 * @param sql,params
		 */
		public function query($sql, $params = [])
		{
			$this->_error = false;
			// Preparing SQL
			if ($this->_query = $this->_pdo->prepare($sql))
			{
				$x = 1;
				// Check params input
				if (count($params))
				{
					foreach ($params as $param)
					{
						// Protecting query inputs and binding values
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}
				// Executing SQL
				if ($this->_query->execute())
				{
					$this->_result = $this->_query->fetchALL(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
					$this->_lastInsertID = $this->_pdo->lastInsertID();
				}
			}
			return $this;
		}

		/**
		 * Returns an result of a specified query request
		 *  
		 * @method Query
		 * @var sql responsable for query instructions
		 * @var params represents the inputs or params to complement the request
		 * @param table represents the table name on database
		 * @param params represents the inputs or params to complement the request
		 */
		protected function _read($table, $params = [])
		{
			$conditionString = '';
			$bind = [];
			$order = '';
			$limit = '';
			$like = '';

			// Check the 'Conditions' existence
			if (isset($params['conditions']))
			{
				// Check if is array
				if (is_array($params['conditions']))
				{
					// [true]
					// traveling the array
					foreach ($params['conditions'] as $condition)
					{
						// record the data
						$conditionString .= ' ' . $condition . ' AND';
					}
					// striping white spaces [begin/end]
					$conditionString = trim($conditionString);
					$conditionString = rtrim($conditionString, ' AND');
				} else {
					// [false]
					$conditionString = $params['conditions'];
				}

				// Next instruction if 1st loop is [true]
				// Check if ins't empty 
				if ($conditionString != '')
				{
					// SQL instruction
					$conditionString = ' Where ' . $conditionString;
				}
			}

			// Binding values
			if (array_key_exists('bind', $params))
			{
				$bind = $params['bind'];
			}

			// Ordenate values string
			if (array_key_exists('order', $params))
			{
				$order = ' ORDER BY ' . $params['order'];
			}

			// Limit the results
			if (array_key_exists('limit', $params))
			{
				$limit = ' LIMIT ' . $params['limit'];
			}

			// Sort results
			if (array_key_exists('like', $params))
			{
				$like = ' LIKE %' . $params['like'] . '%';
			}

			// Query string
			$sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}{$like}";
			
			// Executing command
			if($this->query($sql, $bind))
			{
				if(!count($this->_result)) return false;
				return true;
			}
			return false;
		}

		/** Returns the last inserted id from an table */
		protected function getLastInsertedIdFromTable($table)
		{
			return $this->query("SELECT id FROM {$table} ORDER BY id DESC LIMIT 1")->results();
		}

		/**
		 * @param table specifies the table on database to be readed
		 * @param params specifies the targets
		 * Returns an array of results target from database
		 */
		public function find($table, $params = [])
		{
			/** Accessing the @method _read to response the request */
			if ($this->_read($table, $params))
			{
				// [true]
				// Returns the results
				return $this->results();
			}

			// [false]
			// Returns false message
			return false;
		}

		/**
		 * @param table specifies the table on database to be readed
		 * @param params specifies the targets
		 * Returns the first result of array data coming from database 
		 */
		public function findFirst($table, $params = [])
		{
			// Check request
			if ($this->_read($table, $params))
			{
				// [true]
				/** @method first returns the first element from an array */
				return $this->first();
			}
			// [false]
			return false;
		}

		/**
		 * @param table represents the table on database
		 * @param fields represents the inputs that you've on database table 
		 * Create data on database
		 */
		public function create($table, $fields = [])
		{
			$fieldString = '';
			$valueString = '';
			$values = [];

			// locking for field keys
			foreach ($fields as $field => $value)
			{
				$fieldString .= '`'.$field.'`,';
				$valueString .= '?,';
				$values[] = $value;
			}
			// Strip whitespaces
			$fieldString = rtrim($fieldString, ',');
			$valueString = rtrim($valueString, ',');

			// Query instruction
			$sql = " INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString}) ";
			
			// Executing command
			if(!$this->query($sql, $values)->error())
			{
				return true;
			}
			return false;
		}

		/**
		 * @param table represents the table on database
		 * @param id represents the target on table to be updated
		 * @param fields represents the new inputs data that you've on database table 
		 * Update data on database
		 */
		public function update($table, $id, $fields = [])
		{
			// Helpers
			$fieldString = '';
			$values = [];
			// Locking for field keys
			foreach ($fields as $field => $value)
			{
				$fieldString .= ' ' . $field . ' = ?,';
				$values[] = $value;
			}
			// Strip whitespaces
			$fieldString = trim($fieldString);
			$fieldString = rtrim($fieldString, ',');

			// Query instructions
			$sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
			
			// Executing command
			if (!$this->query($sql, $values)->error())
			{
				return true;
			}
			return false;
		}

		/**
		 * @param table represents the table on database
		 * @param id represents the target on table to be deleted
		 * Delete data on database
		 */
		public function delete ($table, $id)
		{
			// Query instructions
			$sql = "DELETE FROM {$table} WHERE id = {$id}";
			// Executing command
			if (!$this->query($sql)->error())
			{
				return true;
			}
			return false;
		}

		/**
		 * Returns the results
		 */
		public function results()
		{
			return $this->_result;
		}

		/** Returns the first result of an array */
		public function first()
		{
			return (!empty($this->_result[0]))? $this->_result[0] : [];
		}

		/** Returns the @var count value */
		public function count()
		{
			return $this->_count;
		}

		/** Return the last insert ID */
		public function lastID()
		{
			return $this->_lastInsertID;
		}

		/**
		 * @param table represents the target 
		 * Returns the columns table on database */
		public function get_columns($table)
		{
			return $this->query("SHOW COLUMNS FROM {$table}")->results();
		}

		/** Returns the error message for a instruction */
		public function error()
		{
			return $this->_error;
		}

	// EOF
	}
