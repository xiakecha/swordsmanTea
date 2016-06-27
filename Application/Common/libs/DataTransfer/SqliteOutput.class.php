<?php
namespace Common\libs\DataTransfer;
use Common\Libs\DataTransfer\IDataOutput;
class SqliteOutput implements IDataOutput
{
	private $_dataDestination;
	private $_columnNames;
	

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

	// 新建一个sqlite 的表
	public function redeayForInsert()
	{
		$tableName = $this->_dataDestination->getTableName();		
		$this->_dataDestination->getCoon()->execute("drop table if exists ".$tableName);
		$this->_dataDestination->getCoon()->execute($this->_dataDestination->getCreateTableStr());
				
	}

	public function insertRow($rows)
	{
		
		$tableName = $this->_dataDestination->getTableName();
		$this->_dataDestination->getCoon()->startTrans();
		foreach ($rows as $key => $col) {
			$tmpcol = '';
			$colkeyRang = '';
			foreach ($col as $colkey => $colname) {
				$colkeyRang .= $colkey.',';
				$colname = str_replace('"', '', $colname);
				$tmpcol.='"'.htmlspecialchars($colname,ENT_QUOTES).'",';
			}
			$colkeyRang = '('.rtrim($colkeyRang, ",").')';
			$tmpcol = '('.rtrim($tmpcol, ",").')';
			$tmpcol = html_entity_decode($tmpcol, ENT_QUOTES);
			$insertStr = "insert into ".$tableName.$colkeyRang." values"."{$tmpcol}";
			$this->_dataDestination->getCoon()->execute($insertStr);
		}
		$this->_dataDestination->getCoon()->commit();
	}

	public function endInsert(){}
}