<?php
namespace Common\libs\DataTransfer;
class DataTransfer
{
	private $_input;
	private $_ouput;
	private $_columnNames;

	function __construct($input, $output, $columnNames)
	{
		$this->_input = $input;
		$this->_ouput = $output;
		$this->_columnNames = $columnNames;
	}

	public function run()
	{
		
		if (!$this->_ouput->init($this->_columnNames))
		{
			
			return false;
		}
		if (!$this->_input->init($this->_columnNames, $this->_ouput))
		{
			return false;
		}
		$this->_ouput->redeayForInsert();
	    $this->_input->run();		
		return $this->_ouput->endInsert();
	}
}