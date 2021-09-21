<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

require 'vendor/autoload.php';
use \Curl\Curl;
require_once 'userAgent.php';


class HesapAc{

    public $ulke;
    public $veri;
    public $cookie_csrftoken;
    public $cookie_pinterest_sess;
    public $cookie_routing_id;
    public $cookie_b;
    public $cookie_dev_sess;
    public $cookie_country_code;
    public $cookie_session;
    public $curl;
    public $header_csrf;
    public $app_id;
    public $app_sec;
    public $app_code;
    public $user_agent;
    public $proxy_url;
    public $proxy_pass;

    function ulkeSec($ulke){
        $this->ulke = $ulke;
    }

    function getHomepage(){
        global $name;
        global $email;
        global $password;

        $this->veri["name"] = $name;
        $this->veri["email"] = $email;
        $this->veri["password"] = $password;
        $this->user_agent = (new userAgent) ->generate();

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setReferer("https://www.pinterest.com/");
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->get('https://www.pinterest.com/');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            $this->cookie_routing_id = $cookies["_routing_id"];
            $this->cookie_pinterest_sess = $cookies["_pinterest_sess"];
            $this->cookie_csrftoken = $cookies["csrftoken"];
        }else{
            echo "getHomePage() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;
    }

    function postActiveUserResource(){
        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);




        $this->curl->setCookie("_auth",0);
        if($this->cookie_routing_id){
            $this->curl->setCookie("_routing_id",temizle($this->cookie_routing_id));
        }else{
            echo "postActiveUserResource() - '_routing_id' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postActiveUserResource() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postActiveUserResource() - 'csrftoken' Bulunamadı.<br>\n";
        }

        $this->curl->setReferrer('https://www.pinterest.com/');
        $this->curl->setHeader("X-APP-VERSION","89653d2");
        $this->curl->setHeader("X-Pinterest-AppState","active");
        $this->curl->setHeader("Origin",'https://www.pinterest.com/');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("X-Requested-With","XMLHttpRequest");
        $this->curl->setHeader("X-CSRFToken",$this->cookie_csrftoken);


        $data = '{"options":{"data":{"browser":1,"clientUUID":"f880050d-39e1-46a5-9c1f-fcb2f84d0e8e","event_type":7137,"view_type":1,"view_parameter":92,"unauth_id":"a931bd26f8ea4a2bb6c7266614a7e544","appVersion":"89653d2","auxData":{"stage":"prod"}}},"context":{}}';
        $this->curl->post("https://www.pinterest.com/_ngjs/resource/ActiveUserResource/create/",'data='.$data.'&source_url=/');

        $this->curl->close();
        return $this->curl->response;
    }

    function postUserRegisterResource(){
        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);





        $this->curl->setCookie("_auth",0);
        if($this->cookie_routing_id){
            $this->curl->setCookie("_routing_id",temizle($this->cookie_routing_id));
        }else{
            echo "postUserRegisterResource() - '_routing_id' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postUserRegisterResource() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postUserRegisterResource() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/');
        $this->curl->setHeader("X-APP-VERSION","89653d2");
        $this->curl->setHeader("X-Pinterest-AppState","active");
        $this->curl->setHeader("Origin",'https://www.pinterest.com/');
        $this->curl->setHeader("Connection",'keep-alive');
        $this->curl->setHeader("Accept",'application/json, text/javascript, */*, q=0.01');
        $this->curl->setHeader("Accept-Encoding",'gzip, deflate, br');
        $this->curl->setHeader("Accept-Language",'en-US,en;q=0.9,en-US;q=0.8,en;q=0.7');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("X-Requested-With","XMLHttpRequest");
        $this->curl->setHeader("X-CSRFToken",$this->cookie_csrftoken);
        $this->curl->setHeader("Content-Type","application/x-www-form-urlencoded");


        $data = '{"options":{"account_type":"professional","business_name":"'.$this->veri["name"].'","email":"'.$this->veri["email"].'","password":"'.$this->veri["password"].'","has_ads_credits":false,"user_behavior_data":"{}"},"context":{}}';
        $this->curl->post("https://www.pinterest.com/resource/UserRegisterResource/create/",'data='.$data.'&source_url=/');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            $this->cookie_b = $cookies["_b"];
            $this->cookie_pinterest_sess = $cookies["_pinterest_sess"];
            @$this->cookie_csrftoken = $cookies["csrftoken"];
        }else{
            echo "postUserRegisterResource() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function addUser($username,$name,$board,$email,$password,$ip,$site){

        hesapEkle($username,$name,$board,$email,$password,$this->cookie_pinterest_sess,$ip,$site);
    }

    function getDeveloperPage(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);



        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getDeveloperPage() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getDeveloperPage() - '_pinterest_sess' Bulunamadı.<br>\n";
        }

        $this->curl->setReferer("https://developers.pinterest.com/docs/api/pins/?");
        $this->curl->setHeader("Sec-Fetch-Mode","navigate");
        $this->curl->setHeader("Sec-Fetch-User","?1");
        $this->curl->setHeader("Sec-Fetch-Site","same-origin");
        $this->curl->setHeader("Upgrade-Insecure-Requests","1");
        $this->curl->setHeader("Connection","keep-alive");
        $this->curl->setHeader("Accept","*/*");
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->get('https://developers.pinterest.com/apps/');


        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            $this->cookie_country_code = $cookies["country-code"];

            if ($cookies["_dev_sess"]){
                $this->cookie_dev_sess = $cookies["_dev_sess"];
            }else{
                echo "getDeveloperPage() - '_dev_sess' Alınamadı.<br>\n";
            }

            if ($cookies["session"]){
                $this->cookie_session = $cookies["session"];
            }else{
                echo "getDeveloperPage() - 'session' Alınamadı.<br>\n";
            }
        }else{
            echo "getDeveloperPage() - Cookie Alınamadı.<br>\n";
        }

        $terms = $this->curl->response;
        preg_match_all('#<meta name="csrf-token" content="(.*?)"#si',$terms,$csrf);
        $this->header_csrf = $csrf[1][0];

        $this->curl->close();
        return $this->curl->response;
    }

    function getTermsPage(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getTermsPage() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getTermsPage() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_session){
            $this->curl->setCookie("session",temizle($this->cookie_session));
        }else{
            echo "getTermsPage() - 'session' Bulunamadı.<br>\n";
        }
        if($this->cookie_dev_sess){
            $this->curl->setCookie("_dev_sess",temizle($this->cookie_dev_sess));
        }else{
            echo "getTermsPage() - '_dev_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_country_code){
            $this->curl->setCookie("country-code",temizle($this->cookie_country_code));
        }else{
            echo "getTermsPage() - 'country-code' Bulunamadı.<br>\n";
        }

        $this->curl->setReferer("https://developers.pinterest.com/docs/api/pins/?");
        $this->curl->setHeader("Sec-Fetch-Mode","navigate");
        $this->curl->setHeader("Sec-Fetch-User","?1");
        $this->curl->setHeader("Sec-Fetch-Site","same-origin");
        $this->curl->setHeader("Upgrade-Insecure-Requests","1");
        $this->curl->setHeader("Connection","keep-alive");
        $this->curl->setHeader("Accept","*/*");
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->get('https://developers.pinterest.com/terms/?textonly=1');


        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["session"]){
                $this->cookie_session = $cookies["session"];}else{
                echo "getTermsPage() - 'session' Alınamadı.<br>\n";
            }
        }else{
            echo "getTermsPage() - Cookie Alınamadı.<br>\n";
        }

        $terms = $this->curl->response;
        preg_match_all('#<meta name="csrf-token" content="(.*?)"#si',$terms,$csrf);
        $this->header_csrf = $csrf[1][0];

        $this->curl->close();
        return $this->curl->response;

    }

    function postDeveloperApps(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);




        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postDeveloperApps() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postDeveloperApps() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_session){
            $this->curl->setCookie("session",temizle($this->cookie_session));
        }else{
            echo "postDeveloperApps() - 'session' Bulunamadı.<br>\n";
        }
        if($this->cookie_dev_sess){
            $this->curl->setCookie("_dev_sess",temizle($this->cookie_dev_sess));
        }else{
            echo "postDeveloperApps() - '_dev_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_country_code){
            $this->curl->setCookie("country-code",temizle($this->cookie_country_code));
        }else{
            echo "postDeveloperApps() - 'country-code' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://developers.pinterest.com/apps/');
        $this->curl->setHeader("Origin",'https://developers.pinterest.com/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setHeader("Accept-Encoding",'gzip, deflate, br');
        $this->curl->setHeader("Accept-Language",'en-US,en;q=0.9,en-US;q=0.8,en;q=0.7');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("X-Requested-With","XMLHttpRequest");
        $this->curl->setHeader("X-CSRFToken",$this->header_csrf);
        $this->curl->setHeader("Content-Type", "application/json");
        $this->curl->setHeader("Sec-Fetch-Mode", "cors");
        $this->curl->setHeader("Sec-Fetch-Site", "same-origin");


        $data =array(
            'name' => generateRandomString(10),
            'description' => generateRandomString(50),
        );
        $this->curl->post("https://developers.pinterest.com/apps/",$data);


        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["session"]){
                $this->cookie_session = $cookies["session"];}else{
                echo "postDeveloperApps() - 'session' Alınamadı.<br>\n";
            }
        }else{
            echo "postDeveloperApps() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        $response = $this->curl->response;
        $this->app_id = $response->id;
        $this->app_sec = $response->secret;
        return $this->curl->response;

    }

    function patchDeveloperApp(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);




        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "patchDeveloperApp() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "patchDeveloperApp() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_session){
            $this->curl->setCookie("session",temizle($this->cookie_session));
        }else{
            echo "patchDeveloperApp() - 'session' Bulunamadı.<br>\n";
        }
        if($this->cookie_dev_sess){
            $this->curl->setCookie("_dev_sess",temizle($this->cookie_dev_sess));
        }else{
            echo "patchDeveloperApp() - '_dev_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_country_code){
            $this->curl->setCookie("country-code",temizle($this->cookie_country_code));
        }else{
            echo "patchDeveloperApp() - 'country-code' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://developers.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Origin",'https://developers.pinterest.com/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setHeader("Accept-Encoding",'gzip, deflate, br');
        $this->curl->setHeader("Accept-Language",'en-US,en;q=0.9,en-US;q=0.8,en;q=0.7');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("X-Requested-With","XMLHttpRequest");
        $this->curl->setHeader("X-CSRFToken",$this->header_csrf);
        $this->curl->setHeader("Content-Type", "application/json");
        $this->curl->setHeader("Sec-Fetch-Mode", "cors");
        $this->curl->setHeader("Sec-Fetch-Site", "same-origin");


        $data = '{"MAX_COLLABORATORS":100,"web":{"redirectURIs":["https://www.getpostman.com/oauth2/callback"]},"ios":{},"android":{},"description":"kwdrgtqxam0","_loading":false,"_loadingImage":false,"_dirty":true,"_saved":null,"_message":"Updated!"}';
        $this->curl->patch('https://developers.pinterest.com/apps/'.$this->app_id.'/',$data);


        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["session"]){
                $this->cookie_session = $cookies["session"];}else{
                echo "patchDeveloperApp() - 'session' Alınamadı.<br>\n";
            }
        }else{
            echo "patchDeveloperApp() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuth(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);




        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuth() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuth() - '_pinterest_sess' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=code&redirect_uri=https://www.getpostman.com/oauth2/callback&client_id='.$this->app_id.'&scope=read_public,write_public&state=secret');


        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuth() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuth() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthV2(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);




        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthV2() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthV2() - '_pinterest_sess' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=token&redirect_uri=https://www.getpostman.com/oauth2/callback&client_id='.$this->app_id.'&scope=read_public,write_public&state=secret');


        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthV2() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthV2() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthPostCron(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthPostCron() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthPostCron() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4780681810403138606";
        $this->app_sec = "PostCron";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=token&client_id='.$this->app_id.'&state=5e2390817bd9e4.16613229&scope=read_public%2Cwrite_public&redirect_uri=https%3A%2F%2Fpostcron.com%2FgetTokenPinterest%3Fnetwork%3Dpinterest%26type%3Dboard');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthPostCron() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthPostCron() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthViralWoot(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthViralWoot() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthViralWoot() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4852032675273255311";
        $this->app_sec = "ViralWoot";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fviralwoot.com%2Fnew%2Fapp%2Fget-started.php&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships%2Cwrite_relationships');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthViralWoot() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthViralWoot() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthRackPoint(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthRackPoint() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthRackPoint() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4977263223213403522";
        $this->app_sec = "RackPoint";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fwww.rackpoint.co.uk%2Fsocial%2Fuser%2Fcallback%2Fpinterest&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships%2Cwrite_relationships');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthRackPoint() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthRackPoint() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthZapier(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthZapier() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthZapier() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4807492912430459235";
        $this->app_sec = "Zapier";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=token&client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fzapier.com%2Fdashboard%2Fauth%2Foauth%2Freturn%2FPinterestDevAPI%2F&scope=read_public%2Cwrite_public%2Cread_relationships&state=1579379077.47315425741');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthZapier() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthZapier() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthNewChic(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthNewChic() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthNewChic() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4813426898688289101";
        $this->app_sec = "NewChic";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=token&redirect_uri=https%3A%2F%2Fwww.newchic.com%2Foauth.html&client_id='.$this->app_id.'&scope=read_public,write_public&state=qgZbUs6m');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthNewChic() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthNewChic() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthPinAutomatic(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthPinAutomatic() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthPinAutomatic() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "5058415737882855610";
        $this->app_sec = "PinAutomatic";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=token&redirect_uri=https://pinautomatic.herokuapp.com/pinterest-auth&client_id='.$this->app_id.'&scope=read_public,write_public&state=secret');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthPinAutomatic() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthPinAutomatic() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthPromoRepublic(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthPromoRepublic() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthPromoRepublic() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4949532386600698885";
        $this->app_sec = "PromoRepublic";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fapp.promorepublic.com%2Fauth%2Fstep1%2Fpinterest%2Fadd_profile&response_type=token&scope=read_public,write_public');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthPromoRepublic() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthPromoRepublic() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthCrowdFireApp(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthCrowdFireApp() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthCrowdFireApp() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4878278133400222588";
        $this->app_sec = "CrowdFireApp";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?response_type=token&redirect_uri=https%3A%2F%2Fapi2.crowdfireapp.com%2Fauth-starter%2Fapi%2F1.0%2Fauth%2Fpinterest%2Fcallback&scope=write_public%2Cread_public%2Cread_relationships%2Cwrite_relationships&state=hello&client_id='.$this->app_id);

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthCrowdFireApp() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthCrowdFireApp() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthCoSchedule(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthCoSchedule() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthCoSchedule() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4792447879975274930";
        $this->app_sec = "CoSchedule";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fapi.coschedule.com%2Fauth%2Fpinterest%2Fcallback&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=eyJzZXNzaW9uX2lkIjoic2pmajRIdHRqYVpjeGJUT1BqU2d6VjJoVGpFci1reGEiLCJ0YXJnZXRfaG9zdCI6Imh0dHBzOi8vYXBpLmNvc2NoZWR1bGUuY29tIn0%3D');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthCoSchedule() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthCoSchedule() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthCanva(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthCanva() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthCanva() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4888378367866317783";
        $this->app_sec = "Canva";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fwww.canva.com%2Foauth%2Fauthorized%2Fpinterest&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=eyJzZXNzaW9uX2lkIjoic2pmajRIdHRqYVpjeGJUT1BqU2d6VjJoVGpFci1reGEiLCJ0YXJnZXRfaG9zdCI6Imh0dHBzOi8vYXBpLmNvc2NoZWR1bGUuY29tIn0%3D');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthCanva() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthCanva() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function getOAuthSofia(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "getOAuthSofia() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "getOAuthSofia() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        $this->app_id = "4835300135359497810";
        $this->app_sec = "Sofia";

        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->get('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fsofia.pinadmin.com%2Foauth2callback&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=eyJzZXNzaW9uX2lkIjoic2pmajRIdHRqYVpjeGJUT1BqU2d6VjJoVGpFci1reGEiLCJ0YXJnZXRfaG9zdCI6Imh0dHBzOi8vYXBpLmNvc2NoZWR1bGUuY29tIn0%3D');

        $cookies = $this->curl->getResponseCookies();
        if ($cookies){
            if ($cookies["csrftoken"]){
                $this->cookie_csrftoken = $cookies["csrftoken"];
            }else{
                echo "getOAuthSofia() - 'csrftoken' Alınamadı.<br>\n";
            }
        }else{
            echo "getOAuthSofia() - Cookie Alınamadı.<br>\n";
        }

        $this->curl->close();
        return $this->curl->response;

    }

    function postOAuth(){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuth() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuth() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuth() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?response_type=code&redirect_uri=https://www.getpostman.com/oauth2/callback&client_id='.$this->app_id.'&scope=read_public,write_public&state=secret',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#data-code="(.*?)"#si',$oauth,$oauth);
        $this->app_code = $oauth[1][0];
        return $this->curl->response;

    }

    function postOAuthPostCron($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthPostCron() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthPostCron() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthPostCron() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?response_type=token&client_id='.$this->app_id.'&client_secret='.$this->app_sec.'&state=5e2390817bd9e4.16613229&scope=read_public%2Cwrite_public&redirect_uri=https%3A%2F%2Fpostcron.com%2FgetTokenPinterest%3Fnetwork%3Dpinterest%26type%3Dboard',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }


    function postOAuthViralWoot($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthViralWoot() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthViralWoot() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthViralWoot() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fviralwoot.com%2Fnew%2Fapp%2Fget-started.php&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships%2Cwrite_relationships',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthRackPoint($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthRackPoint() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthRackPoint() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthRackPoint() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fwww.rackpoint.co.uk%2Fsocial%2Fuser%2Fcallback%2Fpinterest&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships%2Cwrite_relationships',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthZapier($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthZapier() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthZapier() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthZapier() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?response_type=token&client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fzapier.com%2Fdashboard%2Fauth%2Foauth%2Freturn%2FPinterestDevAPI%2F&scope=read_public%2Cwrite_public%2Cread_relationships&state=1579379077.47315425741',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }


    function postOAuthNewChic($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthNewChic() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthNewChic() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthNewChic() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?response_type=token&client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fzapier.com%2Fdashboard%2Fauth%2Foauth%2Freturn%2FPinterestDevAPI%2F&scope=read_public%2Cwrite_public%2Cread_relationships&state=1579379077.47315425741',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthPinAutomatic($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthPinAutomatic() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthPinAutomatic() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthPinAutomatic() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?response_type=token&redirect_uri=https://pinautomatic.herokuapp.com/pinterest-auth&client_id='.$this->app_id.'&scope=read_public,write_public&state=secret',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthPromoRepublic($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthPromoRepublic() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthPromoRepublic() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthPromoRepublic() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fapp.promorepublic.com%2Fauth%2Fstep1%2Fpinterest%2Fadd_profile&response_type=token&scope=read_public,write_public',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthCrowdFireApp($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthCrowdFireApp() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthCrowdFireApp() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthCrowdFireApp() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?response_type=token&redirect_uri=https%3A%2F%2Fapi2.crowdfireapp.com%2Fauth-starter%2Fapi%2F1.0%2Fauth%2Fpinterest%2Fcallback&scope=write_public%2Cread_public%2Cread_relationships%2Cwrite_relationships&state=hello&client_id='.$this->app_id,"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthCoSchedule($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthCoSchedule() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthCoSchedule() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthCoSchedule() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fapi.coschedule.com%2Fauth%2Fpinterest%2Fcallback&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=eyJzZXNzaW9uX2lkIjoic2pmajRIdHRqYVpjeGJUT1BqU2d6VjJoVGpFci1reGEiLCJ0YXJnZXRfaG9zdCI6Imh0dHBzOi8vYXBpLmNvc2NoZWR1bGUuY29tIn0%3D',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthCanva($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthCanva() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthCanva() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthCanva() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fwww.canva.com%2Foauth%2Fauthorized%2Fpinterest&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=fe0f73c2-b6d4-4b41-8e3a-d36ff24f5f6b',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postOAuthSofia($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postOAuthSofia() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postOAuthSofia() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthSofia() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https%3A%2F%2Fsofia.pinadmin.com%2Foauth2callback&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=fe0f73c2-b6d4-4b41-8e3a-d36ff24f5f6b',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }

    function postApiV1($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);




        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postApiV1() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postApiV1() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postApiV1() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/v1/oauth/token?grant_type=authorization_code&client_id='.$this->app_id.'&client_secret='.$this->app_sec.'&code='.$this->app_code.'',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        tokenEkle($username,$this->app_id,$this->app_sec,$this->curl->response->access_token,$site);
        return $this->curl->response;

    }


    function postApiV2($username,$site){

        $this->curl = new Curl();

        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        $this->curl->setOpt(CURLOPT_PROXY, $this->proxy_url);
        $this->curl->setOpt(CURLOPT_PROXYUSERPWD, $this->proxy_pass);


        $this->curl->setCookie("_auth",1);
        $this->curl->setCookie("_ir",0);
        if($this->cookie_b){
            $this->curl->setCookie("_b",temizle($this->cookie_b));
        }else{
            echo "postApiV2() - '_b' Bulunamadı.<br>\n";
        }
        if($this->cookie_pinterest_sess){
            $this->curl->setCookie("_pinterest_sess",temizle($this->cookie_pinterest_sess));
        }else{
            echo "postApiV2() - '_pinterest_sess' Bulunamadı.<br>\n";
        }
        if($this->cookie_csrftoken){
            $this->curl->setCookie("csrftoken",temizle($this->cookie_csrftoken));
        }else{
            echo "postOAuthV2() - 'csrftoken' Bulunamadı.<br>\n";
        }


        $this->curl->setReferrer('https://www.pinterest.com/apps/'.$this->app_id.'/');
        $this->curl->setHeader("Accept",'*/*');
        $this->curl->setUserAgent($this->user_agent);
        $this->curl->setHeader("Content-Type", "application/x-www-form-urlencoded");

        $this->curl->post('https://api.pinterest.com/oauth/?client_id='.$this->app_id.'&redirect_uri=https://www.getpostman.com/oauth2/callback&response_type=token&scope=read_public%2Cwrite_public%2Cread_relationships&state=secret',"csrf_token=".$this->cookie_csrftoken);

        $this->curl->close();
        $oauth = $this->curl->response;
        preg_match_all('#access_token=(.*?)"#si',$oauth,$oauth);

        tokenEkle($username,$this->app_id,$this->app_sec,$oauth[1][0],$site);
        return $this->curl->response;

    }


}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function hesapEkle($username,$name,$board,$email,$password,$pinterest_sess,$ip,$site){
    global $db;
    if (empty($name)){ echo "Isim Bulunamadı<br>\n"; }
    if (empty($board)){ echo "Board Bulunamadı<br>\n"; }
    if (empty($username)){ echo "Kullanıcı Adı Bulunamadı<br>\n"; }
    if (empty($email)){ echo "Email Bulunamadı<br>\n"; }
    if (empty($password)){ echo "Password Bulunamadı<br>\n"; }
    if (empty($pinterest_sess)){ echo "Pinterest_sess Bulunamadı<br>\n"; }
    if ($username and $email and $password and $pinterest_sess){


        if ($username and $email and $password and $ip){
            $query = $db->prepare("INSERT INTO accounts SET username = :username, name = :name, board = :board, email = :email, password = :password, pinterest_sess = :pinterest_sess, ip = :ip");
            $insert = $query->execute(array(
                "username" => $username,
                "name" => $name,
                "board" => $board,
                "email" => $email,
                "password" => $password,
                "pinterest_sess" => $pinterest_sess,
                "ip" => $ip,
            ));
            if ( $insert ){
                $last_id = $db->lastInsertId();
                echo 'Hesap Eklendi.<br>';
            }else{
                echo 'Hesap Eklenemedi.<br>';
            }
        }else{
            echo 'Hesap Bilgileri Eksik.<br>';
        }

    }
}

function tokenEkle($username,$app_id,$app_sec,$access_token,$site){
    global $db;
    if (empty($username)){ echo "Kullanıcı Adı Bulunamadı<br>\n"; }
    if (empty($app_id)){ echo "App ID Bulunamadı<br>\n"; }
    if (empty($app_sec)){ echo "App Secret Bulunamadı<br>\n"; }
    if (empty($access_token)){ echo "Access Token Bulunamadı<br>\n"; }

    $account_id = get_account_id($username);

    if ($username and $account_id and $app_id and $app_sec and $access_token){
        $query = $db->prepare("INSERT INTO account_tokens SET account_id = :account_id, app_id = :app_id, app_secret = :app_secret, access_token = :access_token");
        $insert = $query->execute(array(
            "account_id" => $account_id,
            "app_id" => $app_id,
            "app_secret" => $app_sec,
            "access_token" => $access_token,
        ));
        if ( $insert ){
            $last_id = $db->lastInsertId();
            echo 'Token Eklendi.<br>';
        }else{
            echo 'Token Eklenemedi.<br>';
        }
    }else{
        echo '<p class="btn btn-block btn-warning" style="margin-bottom: 5px;">Token Bilgileri Eksik.</p>';
    }
}



function temizle($s){
    $s = str_replace('"',"",$s);
    return $s;
}


function getName(){
    $name = file_get_contents_curl2("https://www.behindthename.com/random/random.php?number=2&sets=1&gender=both&surname=&norare=yes&all=yes");
    preg_match_all("#<span class=\"random-result\">(.*?)</span>#si",$name,$nameobj);
    return trim(preg_replace("/\s+/", " ", strip_tags($nameobj[1][0])));
}

function getName2(){
    $name = file_get_contents_curl2("https://randomuser.me/api/");
    $nameobj = json_decode($name);
    return $randomName = $nameobj->results[0]->name->first." ".$nameobj->results[0]->name->last;
}

function file_get_contents_curl2($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
function slug($str, $replace=array(), $delimiter='.') {
    if ( !empty($replace) ) {
        $str = str_replace((array)$replace, ' ', $str);
    }
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '.'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    return $clean;
}

function dilSec(){
    $dil = array("AU","AT","BE","CA","GB","US","DK","FR","DE","IT","NL","NO");
    $ulke = array("en-AU","de","nl","fr","en-GB","en-US","da-DK","fr","de","it","nl","nb-NO");
    $rand = rand(0,11);
    $result = ["dil" => $dil[$rand], "ulke" => $ulke[$rand]];
    return $result;
}

function resize($newWidth, $targetFile, $originalFile) {

    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;

        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;

        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;

        default:
            throw new Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);

    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
    $image_save_func($tmp, "$targetFile.$new_image_ext");
}