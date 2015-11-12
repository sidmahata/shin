<?php


namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CreateShortCode{

    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";


    public function checkValidUrl($url){

        if(empty($url)){
            $shortcode = "No URL was supplied.";
        }elseif($this->validateUrlFormat($url) == false){
            $shortcode = "URL does not have a valid format.";
        }elseif (!$this->verifyUrlExists($url)) {
                $shortcode = "URL does not appear to exist.";
        }else{
            $shortcode = $url;
        }

        return $shortcode;
    }

    protected function validateUrlFormat($url) {

//        Recognizes ftp://, ftps://, http:// and https:// in a case insensitive way and adds http:// if not present
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

//       Remove all illegal characters from a url
        $url = filter_var($url, FILTER_SANITIZE_URL);

        return filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED);
    }

    protected function verifyUrlExists($url) {
//        Recognizes ftp://, ftps://, http:// and https:// in a case insensitive way and adds http:// if not present
        if (strpos($url, "https://")!== false) {
            $url = str_replace("https","http",$url);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    public function convertIntToShortCode($id) {
        $id = intval($id);
        if ($id < 1) {
            throw new Exception(
                "The ID is not a valid integer");
        }

        $length = strlen(self::$chars);
        // make sure length of available characters is at
        // least a reasonable minimum - there should be at
        // least 10 characters
        if ($length < 10) {
            throw new Exception("Length of chars is too small");
        }

        $code = "";
        while ($id > $length - 1) {
            // determine the value of the next higher character
            // in the short code should be and prepend
            $code = self::$chars[fmod($id, $length)] .
                $code;
            // reset $id to remaining value to be converted
            $id = floor($id / $length);
        }

        // remaining value of $id is less than the length of
        // self::$chars
        $code = self::$chars[$id] . $code;

        return $code;
    }


} 