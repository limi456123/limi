<?php


class CaptchaController extends Controller
{
    public function Captcha()    {
        $row="23456789QWERTYUPASDFGHJKLZXCVBNM";
        $result=str_shuffle( $row);
        $random=substr( $result,0,3);
        session_start();
        $_SESSION['random']=$random;
        $images=PUBLIC_PATH."Admin/captcha/captcha_bg".mt_rand(1,5).".jpg";
        $image=imagecreatefromjpeg($images);
        $imagesize=getimagesize($images);
        list($width,$height)=$imagesize;
        $white=imagecolorallocate($image,255,255,255);
        $blue=imagecolorallocate($image,0,0,0);
        imagestring($image,5,$width/3,$height/6,$random,mt_rand(0,1)?$white:$blue);
        imagerectangle($image,0,0,$width-1,$height-1,$white);
        header("Content-Type:image/jpeg");
        imagejpeg($image);
        imagedestroy($image);

    }

}