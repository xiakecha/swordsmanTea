<?php
namespace Common\libs\DataTransfer;
class DBDataDestination
{
	private $_coon;
	private $_tableName;
	private $_CreateTableStr;
	function __construct($coon, $tableName, $CreateTableStr)
	{
		$this->_coon = $coon;
		$this->_tableName = $tableName;
		$this->_CreateTableStr = $CreateTableStr;
	}

	public function getCoon()
	{
		return $this->_coon;
	}

	public function getTableName()
	{
		return $this->_tableName;
	}

	public function getCreateTableStr()
	{
		return $this->_CreateTableStr;
	}


}