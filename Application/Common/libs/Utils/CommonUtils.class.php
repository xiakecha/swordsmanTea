<?php
namespace Common\Libs\Utils;

class CommonUtils
{
    public static function getFiledate($file) {
           if (is_file($file)) {
              $filePath = $file;
              if (!realpath($filePath)) {
                 $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
              }
              
              return filemtime($filePath);
           }
           
           return false;
    }
    
    public static function curlRedirect($url, $postParam = array(), $headParam = array())
    {
		header("Content-type: text/json; charset=utf-8"); 
        $ch = \curl_init($url);
        if ($postParam)
        {
            \curl_setopt($ch, CURLOPT_POST, 1);
            \curl_setopt($ch, CURLOPT_POSTFIELDS, $postParam);
        }
        
        if ($headParam)
        {
            $headOpts = array();
            foreach ($headParam as $key => $value) {
                $headOpts[] = $key.":".$value;
            }
            \curl_setopt($ch, CURLOPT_HTTPHEADER, $headOpts); 
        }
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = \curl_exec($ch);
        \curl_close($ch);
        return $result;
    }
    
	/**
	 * 邮件发送函数
	 */
    public static function sendMail($to, $title, $content,$attachArray= NULL ) {
        //Vendor('PHPMailer.PHPMailerAutoload');
        Vendor('phpmailer.class#phpmailer');
        $mail = new \PHPMailer(); //实例化
        $mail->IsSMTP(); // 启用SMTP
        $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
        $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
        $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
        $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
        $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
        $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
        $mail->AddAddress($to,"尊敬的管理员");
        $mail->WordWrap = 50; //设置每行字符长度
        if($attachArray){
        	$num = count($attachArray);
        	for($i = 0; $i < $num; $i++){
        		$mail->AddAttachment($attachArray[$i]["path"], $attachArray[$i]["name"]);
        	}
        }

        $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
        $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
        $mail->Subject =$title; //邮件主题
        $mail->Body = $content; //邮件内容
        $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
        $ret=$mail->Send();
        $mail->SmtpClose();
        return(true);
    }
}
