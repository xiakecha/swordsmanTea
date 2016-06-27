<?php
namespace Common\libs\DataTransfer;
interface IDataInput
{
	public function init($columnNames, $funDataDeal);
	public function run();
}
