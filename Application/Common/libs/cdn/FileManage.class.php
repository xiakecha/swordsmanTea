<?php
/**
 * Created by PhpStorm.
 * User: wsw
 * Date: 2015/11/30
 * Time: 10:08
 */
namespace Common\Libs\FileManage;

class FileManage {
    /**
     * @param $url  url地址
     * @return bool|mixed
     */
    public static function uploadHandle($url) {

        $model = M('kmadmin.file_manage', 'km_tbl_');

        $data['url'] = $url;
        $result = $model->where($data)->find();
        if ($result) {
            return $result['id'];
        }
        $result = $model->add($data);
        if ($result) {
            return $result;
        }
        return -1;
    }

    public static function getUrlById($id) {
        $result = M('kmadmin.file_manage', 'km_tbl_')->where(array('id'=>$id))->find();
        if ($result) {
            return $result['url'];
        }
        return -1;
    }
}