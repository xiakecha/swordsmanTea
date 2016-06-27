<?php
namespace Common\libs\DataTransfer;
use Common\Libs\DataTransfer\IDataOutput;

class SongSourcetxtOutput implements IDataOutput{
	private $_dataDestination;
	private $_columnNames;
	private $_rows;
	function __construct($dataDestination){
		$this->_dataDestination = $dataDestination;
	}

	public function init($columnNames){
		if (!$this->_dataDestination || !$columnNames) {
			return false;
		}

		if (!($this->_dataDestination instanceof DBDataDestination)){
			return false;
		}

		$this->_columnNames = $columnNames;
		return true;
	}

	
	public function redeayForInsert(){
	
	}
	
	public function insertRow($rows){
		$this->_rows = $rows;			
		$fileName = $this->_dataDestination->getTableName();		
	    foreach ($rows as $key => $col) {
		  	unset($col['soundaccuracyfileid']);
			$lineSourceData .= implode('||', $col);
			$lineSourceData .= "\r\n";
	    }	
	    $flag = $this->_dataDestination->getCreateTableStr();		
	    file_put_contents($fileName, $lineSourceData, $flag);		
	}

	public function endInsert(){
		return $this->_rows;
	}
}