<?php
namespace Common\Libs\cdn;

interface ICdn {
    public function connect_server();
    public function upload_file($fileName, $fileDir);
    public function delete_file($fileName);
    public function info_file($fileName);
}