<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/9/15
 * Time: 5:06 PM
 */

namespace AppBundle\Utils;


class CreateShortCode {

    public function urlToShortCode($url){

        if(empty($url)){
            $shortcode = "No URL was supplied.";
        }elseif($this->validateUrlFormat($url) == false){
            $shortcode = "URL does not have a valid format.";
        }elseif (!$this->verifyUrlExists($url)) {
                $shortcode = "URL does not appear to exist.";
        }else{
            $shortCode = $this->urlExistsInDb($url);
            if ($shortCode == false) {
//            $shortCode = $this->createShortCode($url);
                $shortcode = "shortcode needs to be created";
            }
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

    protected function urlExistsInDb($url) {
        $result = $this->getDoctrine()
            ->getRepository('AppBundle:Url')
            ->findOneById(1);

        return (empty($result)) ? false : 'hello';
    }


} 