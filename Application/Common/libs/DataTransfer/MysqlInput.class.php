<?php
namespace Common\Libs\DataTransfer;
use Common\Libs\DataTransfer\IDataInput;

class MysqlInput implements IDataInput
{
    private $_dataSource;
    private $_columnNames;
    private $_funDataDeal;
	function __construct($dataSource)
	{
		$this->_dataSource = $dataSource;
	}

	public function init($columnNames, $funDataDeal)
	{
		if (!$this->_dataSource || !$columnNames || !$funDataDeal) 
		{
			
			return false;
		}

		if (!($this->_dataSource instanceof DBDataSource))
		{
			
			return false;
		}

		$columns = $this->_dataSource->getColumns();

		$this->_columnNames = $columnNames;
    	$this->_funDataDeal = $funDataDeal;
		return true;
	}

	public function run()
	{
		$columns = $this->_dataSource->getColumns();		
		$sqlDataSource = $this->_dataSource->getSqlDataSource();		
	    $rows = $sqlDataSource->field($columns)->select();
//	    $rows = $sqlDataSource->field($columns)->fetchSql(true)->select();
//	    echo $rows;
//	    exit;
		$this->_funDataDeal->insertRow($rows);
		return true;
	}

	
}