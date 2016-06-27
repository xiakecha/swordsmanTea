<?php
namespace Common\libs\DataTransfer;

class DBDataSource
{
	private $_sqlDataSource = "";
	private $_columns = array();
	function __construct($sqlDataSource, $columns)
	{
		$this->_sqlDataSource = $sqlDataSource;
		$this->_columns = $columns;
	}
	public function getSqlDataSource()
	{
		return $this->_sqlDataSource;
	}

	public function getColumns()
	{
		return $this->_columns;
	}	

}