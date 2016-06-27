<?php
namespace Common\Libs\cdn;

use Common\Libs\FileManage\FileManage;

class CdnManager {

    private static $instance = null;

    /*
     * @return
     * 实例化服务器对象
     */
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new QiNiuCDN();
        }
        return self::$instance;
    }

    public static function upload_file($fileName, $fileBody) {
        self::get_instance()->connect_server();
        
        return self::$instance->upload_file($fileName, $fileBody);
    }

    public static function upload($fileName, $fileBody) {
        self::get_instance()->connect_server();

        $last = strstr($fileName, '.');
        $head = strstr($fileName, '.', true);

        $url = self::$instance->upload_file(md5($head.date('YmdHis')).$last, $fileBody);

        if ($url) {
            return FileManage::uploadHandle($url);
        }
        return false;
    }
    
	public static function delete_file($fileName) {
        self::get_instance()->connect_server();
        return self::$instance->delete_file($fileName);
    }

    public static function info_file($fileName) {
        self::get_instance()->connect_server();
        return self::$instance->info_file($fileName);
    }

    public static function img_url_suffix($w, $h) {
        return self::get_instance()->img_url_suffix($w, $h);
    }
}