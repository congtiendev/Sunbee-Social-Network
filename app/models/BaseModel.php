<?php
	
	namespace App\Models;
	
	use PDO;
	
	class BaseModel
	{
		protected $pdo = NULL;
		protected $sql = '';
		protected $sta = NULL;
		
		public function __construct()
		{
			//set connect
			$this->pdo = new PDO("mysql:host=" . DBHOST
				. ";dbname=" . DBNAME
				. ";charset=" . DBCHARSET,
				DBUSER,
				DBPASS
			);
		}
		
		public function getData($query, $getAll = true)
		{
			$stmt = $this->pdo->prepare($query);
			$stmt->execute();
			if ($getAll) {
				return $stmt->fetchAll();
			}
			
			return $stmt->fetch();
		}
		
		public function setQuery($sql)
		{
			$this->sql = $sql;
		}
		
		public function execute($options = array())
		{
			$this->sta = $this->pdo->prepare($this->sql);
			if ($options) {
				for ($i = 0 ; $i < count($options) ; $i++) {
					$this->sta->bindParam($i + 1, $options[ $i ]);
				}
			}
			$this->sta->execute();
			return $this->sta;
		}
		
		
		public function loadAllRows($options = array())
		{
			if (!$options) {
				if (!$result = $this->execute())
					return false;
			} else {
				if (!$result = $this->execute($options))
					return false;
			}
			return $result->fetchAll(PDO::FETCH_OBJ);
		}
		
		
		public function loadRow($option = array())
		{
			if (!$option) {
				if (!$result = $this->execute())
					return false;
			} else {
				if (!$result = $this->execute($option))
					return false;
			}
			return $result->fetch(PDO::FETCH_OBJ);
		}
		
		
		public function loadRecord($option = array())
		{
			if (!$option) {
				if (!$result = $this->execute())
					return false;
			} else {
				if (!$result = $this->execute($option))
					return false;
			}
			return $result->fetch(PDO::FETCH_COLUMN);
		}
		
		
		
		public function getLastId()
		{
			return $this->pdo->lastInsertId();
		}
		
		public function selectBy(string $table, string $column, int $id = null, string $value)
		{
			$sql = "SELECT * FROM $table";
			if ($id !== null) {
				$sql .= " WHERE $column = ? AND id != $id";
			} else {
				$sql .= " WHERE $column = ?";
			}
			$this->setQuery($sql);
			return $this->loadRow(array($value));
		}
		
		public function disconnect()
		{
			$this->sta = NULL;
			$this->pdo = NULL;
		}
	}
	
	?>