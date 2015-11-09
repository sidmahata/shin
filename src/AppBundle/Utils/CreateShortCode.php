<?php


namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CreateShortCode{


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
        return filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED);
    }

    protected function verifyUrlExists($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }


} 