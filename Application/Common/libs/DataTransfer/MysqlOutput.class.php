<?php
namespace Common\libs\DataTransfer;
use Common\Libs\DataTransfer\IDataOutput;

class MysqlOutput implements IDataOutput{
	private $_dataDestination;
	private $_columnNames;
	private $_coon;

	function __construct($dataDestination)
	{
		$this->_dataDestination = $dataDestination;
	}

	public function init($columnNames)
	{
		if (!$this->_dataDestination || !$columnNames) {
			return false;
		}

		if (!($this->_dataDestination instanceof DBDataDestination))
		{
			return false;
		}

		$this->_columnNames = $columnNames;
		return true;
	}

	public function redeayForInsert()
	{
		
	    $tableName = $this->_dataDestination->getTableName();  
	    $createTableStr = $this->_dataDestination->getCreateTableStr();
	    if ($createTableStr != '') {
	    	$this->_dataDestination->getCoon()->execute($createTableStr);
	    }
		$this->_coon = M($tableName, null);			
	}

	public function insertRow($rows)
	{
		
		$tableName = $this->_dataDestination->getTableName();
		$dataList = array();
		foreach ($rows as $col) {
			foreach ($col as $key=>$colname) {
				$data[$key] = htmlspecialchars($colname, ENT_QUOTES);
			}	
			$dataList[] = $data;
		}
		
		$this->_coon->addAll($dataList);
	}
	public function endInsert(){}
}