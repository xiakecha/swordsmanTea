<?php
namespace Common\Libs\cdn;
use Common\Libs\cdn\ICdn;

class QiNiuCDN implements Icdn {

    private $server = "";
    /**
     * 创建连接
     */
    public function connect_server() {
        $setting=C('UPLOAD_SITEIMG_QINIU');
        $this->server = new \Think\Upload\Driver\Qiniu\QiniuStorage($setting['driverConfig']);
    }

    /**
     * @param $fileName  string 文件名
     * @param $fileBody  string 文件路径
     * @return string 改文件cdn上的地址
     */
    public function upload_file($fileName, $fileBody) {

        $uploadFile = array(
            'name'=>'file',
            'fileName'=>$fileName,
            'fileBody'=>file_get_contents($fileBody)
        );
        
        var_dump($uploadFile);

        $info = $this->server->upload(array(), $uploadFile);
        $setting=C('UPLOAD_SITEIMG_QINIU');
        
        
        
        if ($info) {
            return $setting['driverConfig']['domain']."/".$info['key'];
        } else {
            return false;
        }
    }

    public function delete_file($fileName) {
        return $this->server->del($fileName);
    }

    public function info_file($fileName) {
        return $this->server->info($fileName);
    }
    public function img_url_suffix($w, $h) {
        return "?imageView2/1/w/$w/h/$h";
    }
}