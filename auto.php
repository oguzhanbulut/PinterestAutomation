<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
set_time_limit(120);
echo '<meta http-equiv="refresh" content="1">';

$baslangic = time();

function file_get_contents_curl($url,$ulke) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_PROXY, '');
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, '');

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$ulkeler = array("us","us","us","us","de","de","fr","fr","gb","gb","gb","nl","nl","at","au","be","nl","ca","lu","ae","ch","se","sz","es","pt","pl","dk","no");
$ulkeCount = count($ulkeler)-1;
$ulkeSec = rand(0,$ulkeCount);
$ulke = $ulkeler[$ulkeSec];

if (empty($ulke)){
    exit();
}

echo $ulke."<br>\n";

$ip = file_get_contents_curl('https://ident.me',$ulke);

function last_ip($ip){

    $json = json_decode(file_get_contents('last_ip.json'));
    $item = array_search($ip, $json);
    if ($item) {
        return "ipvar";
    }else{
        $json = array_slice($json, 1);
        array_push($json,$ip);
        $newJson = json_encode($json);
        file_put_contents('last_ip.json', $newJson);
        return "ipserbest";
    }
}
require_once("class.php");
use seregazhuk\PinterestBot\Factories\PinterestBot;
use seregazhuk\PinterestBot\Api\Forms\Profile;

echo $ip."<br>\n";
if (last_ip($ip)=="ipvar"){
    echo "IP SON LISTEDE<BR>";
}else{

    flush();
    echo date("H:i:s")." - ip_get<br>";
    ob_flush();


    require_once("db.php");
    $sql = $db->prepare("SELECT id FROM accounts WHERE ip = :ip LIMIT 1");
    $sql->execute(array(':ip' => $ip));
    $result = $sql->fetchObject();

    @$ip_check = $result->id;


    flush();
    echo date("H:i:s")." - ip_check<br>";
    ob_flush();


    if ($ip_check>0){
        echo "BU IP KULLANILMIS<br>\n";
    }else{

        $randomName = getName();
        $randomUsername = slug($randomName);
        $name = $randomName;
        $randPass = rand(1000,9999);
        $email = $randomUsername.$randPass."@gmail.com";
        $board = explode(" ",$randomName)[0];
        $password = $randPass;
        $adet = 2;
        $site = "uleso.com";

        echo $email."<br>\n";

        if ($name and $email and $password and $adet) {


            $avatarx = rand(10000,99999);
            $org = "avatar/avatar".$avatarx."-org.png";
            $res = "avatar/avatar".$avatarx;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.thispersondoesnotexist.com/image");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $imgdata = curl_exec($ch);

            file_put_contents($org, $imgdata);

            resize(512, $res, $org);
            $avatar = "avatar/avatar".$avatarx.".jpg";

            $hesap = new HesapAc();
            $hesap->ulkeSec($ulke);
            flush();
            echo date("H:i:s")." - ulkeSec<br>";
            ob_flush();
            $hesap->getHomepage();
            flush();
            echo date("H:i:s")." - getHomepage<br>";
            ob_flush();
            $hesap->postActiveUserResource();
            flush();
            echo date("H:i:s")." - postActiveUserResource<br>";
            ob_flush();
            $hesap->postUserRegisterResource();


            flush();
            echo date("H:i:s")." - postUserRegisterResource<br>";
            ob_flush();

            $bot = PinterestBot::create();
            $bot->getHttpClient()->useProxy('', '', '');
            $result = $bot->auth->login($email, $password);

            flush();
            echo date("H:i:s")." - PinterestBot<br>";
            ob_flush();

            if (!$result) {
                echo $bot->getLastError();
                echo "\n";
                die();
            }
            if ($board){
                $bot->boards->create($board, '');
            }

            flush();
            echo date("H:i:s")." - createBoard<br>";
            ob_flush();

            $username = $bot->user->username();

            flush();
            echo date("H:i:s")." - username<br>";
            ob_flush();
            $hesap->addUser($username,$name,$board,$email,$password,$ip,$site);

            flush();
            echo date("H:i:s")." - addUser<br>";
            ob_flush();


            $hesap->getDeveloperPage();
            flush();
            echo date("H:i:s")." - getDeveloperPage<br>";
            ob_flush();
            $hesap->getTermsPage();
            flush();
            echo date("H:i:s")." - getTermsPage<br>";
            ob_flush();


            $apiList = array(
                "PinAutomatic",
                "PromoRepublic",
                "RackPoint",
                "ViralWoot",
                "Zapier",
                "CrowdFireApp",
                "CoSchedule",
                "Canva",
            );


            $apiSec = array_rand($apiList, $adet);

            $apiOlustur = array();
            array_push($apiOlustur,$apiList[$apiSec[0]]);
            array_push($apiOlustur,$apiList[$apiSec[1]]);

            if (in_array("PinAutomatic", $apiOlustur)){

                flush();
                echo date("H:i:s")." - PinAutomatic<br>";
                ob_flush();

                $hesap->getOAuthPinAutomatic();
                $hesap->postOAuthPinAutomatic($username,$site);
            }
            if (in_array("PromoRepublic", $apiOlustur)){

                flush();
                echo date("H:i:s")." - PromoRepublic<br>";
                ob_flush();

                $hesap->getOAuthPromoRepublic();
                $hesap->postOAuthPromoRepublic($username,$site);
            }
            if (in_array("RackPoint", $apiOlustur)){

                flush();
                echo date("H:i:s")." - RackPoint<br>";
                ob_flush();

                $hesap->getOAuthRackPoint();
                $hesap->postOAuthRackPoint($username,$site);
            }
            if (in_array("ViralWoot", $apiOlustur)){

                flush();
                echo date("H:i:s")." - ViralWoot<br>";
                ob_flush();

                $hesap->getOAuthViralWoot();
                $hesap->postOAuthViralWoot($username,$site);
            }
            if (in_array("Zapier", $apiOlustur)){

                flush();
                echo date("H:i:s"). " - Zapier<br>";
                ob_flush();

                $hesap->getOAuthZapier();
                $hesap->postOAuthZapier($username,$site);
            }
            if (in_array("CrowdFireApp", $apiOlustur)){

                flush();
                echo date("H:i:s"). " - CrowdFireApp<br>";
                ob_flush();

                $hesap->getOAuthCrowdFireApp();
                $hesap->postOAuthCrowdFireApp($username,$site);
            }
            if (in_array("CoSchedule", $apiOlustur)){

                flush();
                echo date("H:i:s"). " - CoSchedule<br>";
                ob_flush();

                $hesap->getOAuthCoSchedule();
                $hesap->postOAuthCoSchedule($username,$site);
            }
            if (in_array("Canva", $apiOlustur)){

                flush();
                echo date("H:i:s"). " - Canva<br>";
                ob_flush();

                $hesap->getOAuthCanva();
                $hesap->postOAuthCanva($username,$site);
            }


            $profileForm = (new Profile())
                ->setImage($avatar);
            $bot->user->profile($profileForm);


            flush();
            echo date("H:i:s"). " - profileForm<br>";
            ob_flush();

            echo "BITIS: ".date("i:s",(time()-$baslangic));
        }
    }
}