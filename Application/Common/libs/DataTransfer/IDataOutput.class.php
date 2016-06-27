<?php
namespace Common\libs\DataTransfer;
interface IDataOutput
{
	public function init($columnNames);
	public function redeayForInsert();
	public function insertRow($row);
	public function endInsert();
}