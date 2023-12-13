<?php
namespace Core;
defined("APPPATH") OR die("Access denied");

use \Core\App;
use \App\models\MasterDom AS MasterDomDao;

Class MasterDom{

    static $_dominio = 'coinkcoink.com';
    static $_data;

    public static function getDomain(){
        $domain = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
        if($_SERVER['SERVER_PORT'] != 80 || $_SERVER['SERVER_PORT'] != 443)
            $domain = $domain . ":" . $_SERVER['SERVER_PORT'];
        return $domain;
    }

    public static function moverInputFile($imagen, $ruta ,$nuevo_nombre){
        try{
            $nombre = explode('.', $imagen['name']);
            $nuevo_nombre .= '.'.$nombre[count($nombre)-1];
            if(move_uploaded_file($imagen['tmp_name'] , $ruta.$nuevo_nombre)){
                chmod($ruta.$nuevo_nombre, 0777);
                return $nuevo_nombre;
            }
        }catch(\Exception $e){
            print_r($e);
            return '';
        }
    }

    public static function convertBase64Image($img_url){
        $extension = explode('.',$img_url);
        $extension = $extension[count($extension)-1];
        if($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'PNG' ||$extension == 'JPG' ||$extension == 'JPEG'){
            return "data:image/$extension;base64,".base64_encode(file_get_contents($img_url));
        }elseif($extension == 'zip' || $extension == 'ZIP'){
            return "data:application/$extension;base64,".base64_encode(file_get_contents($img_url));
        }
    }

    public static function getCustomer(){
        session_start();
        return $_SESSION['customer_id'];
    }

    public static function getUser(){
        session_start();
        return $_SESSION['user_id'];
    }

    public static function curlPostJava($url, $json, $token = false){

        $fecha = date('Y-m-d H:i:s');
        $fecha1 = md5($fecha);
        $fecha2 = md5($fecha1);

        $user = 'airmovil';
        $pwd = base64_encode('4irM0v77k');
        $pwd = base64_encode($pwd);

        $pwd = base64_encode("$fecha2|$pwd|$fecha1");
        $username = md5("$user-$pwd");
        $token = md5("$username-$fecha2");

        $json['acceso']['token'] = $token;
        $json['acceso']['fecha'] = $fecha;
        $json['acceso']['user'] = $user;
        $json['acceso']['password'] = $pwd;

        $url = 'http://domain:6654/'.$url;
        $json =json_encode($json);

        $curl=curl_init($url);
    	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    	curl_setopt($curl, CURLOPT_HEADER, false);
    	curl_setopt($curl, CURLOPT_POST, 1);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    	curl_setopt($curl, CURLOPT_POSTFIELDS,$json);

    	$result = curl_exec($curl);
	
    	$result = json_decode($result,1);
    	curl_close($curl);
    	return $result;
    }

    public static function setTituloIdWeb($titulo, $id){
	    return trim(self::setTituloWeb($titulo).'-'.$id);
    }

    public static function getIdTitle($titulo){
	    return array_pop(explode('-',$titulo));
    }

    public static function noAcentos($string){
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."),
             '',
             $string
        );

        return $string;
    }

    public static function noAcentos2($string){
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
        array("\\", "¨", "º", "~", "|", "¡", "\"", "·", "¿", "[", "^", "`", "]", "¨", "´"),'',$string);
        return $string;
    }

    public static function limpiaCadena($string){
        $string = preg_replace(
        array('/\bante\b/','/\bbajo\b/','/\bcabe\b/','/\bcon\b/','/\bcontra\b/','/\bde\b/',
            '/\bdesde\b/','/\ben\b/','/\bentra\b/','/\bhacia\b/','/\bhasta\b/','/\bpara\b/',
            '/\bpor\b/','/\bsegun\b/','/\bsin\b/','/\bsobre\b/','/\btras\b/','/\bnada\b/'),
            '',
            $string
        );

        $string = preg_replace(
            array('/\bel\b/','/\bla\b/','/\blo\b/','/\bal\b/','/\blos\b/','/\blas\b/','/\bdel\b/','/\bun\b/','/\bunos\b/','/\buna\b/','/\bunas\b/',
            '/\bpor\b/','/\bsegun\b/','/\bsin\b/','/\bsobre\b/','/\besta\b/','/\bestas\b/','/\bese\b/','/\besos\b/'),
                '',
                $string
            );

        $string = preg_replace(
            array('/\by\b/','/\bcomo\b/','/\bpara\b/','/\bcon\b/','/\bdonde\b/','/\bquien\b/','/\bcuando\b/','/\bque\b/','/\bcual\b/','/\bcuales\b/','/\btodo\b/',
                '/\bpara que\b/','/\bporque\b/','/\bpor que\b/','/\bsobre\b/','/\ba\b/','/\be\b/','/\bi\b/','/\bo\b/','/\bu\b/'),
                '',
                $string
            );
        
        return $string;
    }

    public static function noSoloAcentos($string){
        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        return $string;
    }

    public static function getTituloWeb($value){
        return str_replace('-',' ',$value);
    }

    public static function setTituloWeb($value){
        return strtolower(self::noAcentos(str_replace(' ','-',$value)));
    }

    public static function getUriPage(){
        return $_SERVER['REQUEST_URI'];
    }

    public static function getParams(){
        return self::$_data;
    }

    /*SHOW DATA VIEW*/
    public static function setParams($key, $value){
        self::$_data[$key] = $value;
    }

    public static function getData($value){

        if(!self::whiteListeIp())
            return false;

        $data = '';
        if(isset($_GET[$value]))
            $data = self::cleanData($_GET[$value]);
        else if(isset($_POST[$value]))
            $data = self::cleanData($_POST[$value]);
        else
            $data = '';

        return $data;
    }

    public static function getDataAll($value){
	    if(!self::whiteListeIp())
            return false;

        $data = '';
        if(isset($_GET[$value]))
            $data = $_GET[$value];
        else if(isset($_POST[$value]))
            $data = $_POST[$value];
        else
            $data = '';

        return $data;
    }

    public static function getDataAlls($value){
        if(!self::whiteListeIp())
            return false;

        $data = '';
        if (isset($_GET))
            $data = $_GET;
        else if(isset($_POST))
            $data = $_POST;
        else
            $data = '';

        return $data;
    }

    public static function cleanData($value){
        $clean = strip_tags($value);
        return htmlentities($clean);
    }

    public static function setCookies($name, $value, $dia = 10){
        if(!self::whiteListeIp())
            return false;

        $dias = (86400 * $dia);
        try{
            setcookie( $name, $value, time() + ($dias), "/", $_SERVER["HTTP_HOST"], isset($_SERVER["HTTPS"]), true);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public static function getCookies($value){
        if(!self::whiteListeIp())
            return false;

        if(isset($_COOKIE[$value]))
            return $_COOKIE[$value];

        return false;
    }

    public static function deleteCookies($value){

        if(!self::whiteListeIp())
            return false;

        try{
            unset($_COOKIE[$value]);
            setcookie($value, '', time() - 86400, "/", $_SERVER["HTTP_HOST"], isset($_SERVER["HTTPS"]), true);
	        unset($_COOKIE[$value]);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public static function setParamSecure($value){
        $string = md5(uniqid()).base64_encode('STRING'.$value.'STRING').md5(date('Y-m-d'));
        $str = base64_encode($string);
        return $str;
    }

    public static function getParamSecure($value){
        if($value == '')
            return false;
        $stringUno = base64_decode($value);
        $string = base64_decode($stringUno);
        $str = explode('STRING',$string);
        $key = (int)$str[1];
        return $key;
    }

    public static function getParamSecureString($value){
        if($value == '')
            return false;
        $stringUno = base64_decode($value);
        $string = base64_decode($stringUno);
        $str = explode('STRING',$string);
        $key = $str[1];
        return $key;
    }

    /**
    * Unaccent the input string string. An example string like `ÀØėÿᾜὨζὅБю`
    * will be translated to `AOeyIOzoBY`. More complete than :
    *   strtr( (string)$str,
    *          "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
    *          "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn" );
    *
    * @param $str input string
    * @param $utf8 if null, function will detect input string encoding
    * @return string input string without accent
    */
    public static function removeAccents( $str, $utf8=true ){
        $str = (string)$str;
        if( is_null($utf8) ) {
            if( !function_exists('mb_detect_encoding') ) {
                $utf8 = (strtolower( mb_detect_encoding($str) )=='utf-8');
            } else {
                $length = strlen($str);
                $utf8 = true;
                for ($i=0; $i < $length; $i++) {
                    $c = ord($str[$i]);
                    if ($c < 0x80) $n = 0; # 0bbbbbbb
                    elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
                    elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
                    elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
                    elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
                    elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
                    else return false; # Does not match any model
                    for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                        if ((++$i == $length)
                            || ((ord($str[$i]) & 0xC0) != 0x80)) {
                            $utf8 = false;
                            break;
                        }
                        
                    }
                }
            }
            
        }
        
        if(!$utf8)
            $str = utf8_encode($str);
        $transliteration = array(
        'Ĳ' => 'I', 'Ö' => 'O','Œ' => 'O','Ü' => 'U','ä' => 'a','æ' => 'a',
        'ĳ' => 'i','ö' => 'o','œ' => 'o','ü' => 'u','ß' => 's','ſ' => 's',
        'À' => 'A','Á' => 'A','Â' => 'A','Ã' => 'A','Ä' => 'A','Å' => 'A',
        'Æ' => 'A','Ā' => 'A','Ą' => 'A','Ă' => 'A','Ç' => 'C','Ć' => 'C',
        'Č' => 'C','Ĉ' => 'C','Ċ' => 'C','Ď' => 'D','Đ' => 'D','È' => 'E',
        'É' => 'E','Ê' => 'E','Ë' => 'E','Ē' => 'E','Ę' => 'E','Ě' => 'E',
        'Ĕ' => 'E','Ė' => 'E','Ĝ' => 'G','Ğ' => 'G','Ġ' => 'G','Ģ' => 'G',
        'Ĥ' => 'H','Ħ' => 'H','Ì' => 'I','Í' => 'I','Î' => 'I','Ï' => 'I',
        'Ī' => 'I','Ĩ' => 'I','Ĭ' => 'I','Į' => 'I','İ' => 'I','Ĵ' => 'J',
        'Ķ' => 'K','Ľ' => 'K','Ĺ' => 'K','Ļ' => 'K','Ŀ' => 'K','Ł' => 'L',
        'Ñ' => 'N','Ń' => 'N','Ň' => 'N','Ņ' => 'N','Ŋ' => 'N','Ò' => 'O',
        'Ó' => 'O','Ô' => 'O','Õ' => 'O','Ø' => 'O','Ō' => 'O','Ő' => 'O',
        'Ŏ' => 'O','Ŕ' => 'R','Ř' => 'R','Ŗ' => 'R','Ś' => 'S','Ş' => 'S',
        'Ŝ' => 'S','Ș' => 'S','Š' => 'S','Ť' => 'T','Ţ' => 'T','Ŧ' => 'T',
        'Ț' => 'T','Ù' => 'U','Ú' => 'U','Û' => 'U','Ū' => 'U','Ů' => 'U',
        'Ű' => 'U','Ŭ' => 'U','Ũ' => 'U','Ų' => 'U','Ŵ' => 'W','Ŷ' => 'Y',
        'Ÿ' => 'Y','Ý' => 'Y','Ź' => 'Z','Ż' => 'Z','Ž' => 'Z','à' => 'a',
        'á' => 'a','â' => 'a','ã' => 'a','ā' => 'a','ą' => 'a','ă' => 'a',
        'å' => 'a','ç' => 'c','ć' => 'c','č' => 'c','ĉ' => 'c','ċ' => 'c',
        'ď' => 'd','đ' => 'd','è' => 'e','é' => 'e','ê' => 'e','ë' => 'e',
        'ē' => 'e','ę' => 'e','ě' => 'e','ĕ' => 'e','ė' => 'e','ƒ' => 'f',
        'ĝ' => 'g','ğ' => 'g','ġ' => 'g','ģ' => 'g','ĥ' => 'h','ħ' => 'h',
        'ì' => 'i','í' => 'i','î' => 'i','ï' => 'i','ī' => 'i','ĩ' => 'i',
        'ĭ' => 'i','į' => 'i','ı' => 'i','ĵ' => 'j','ķ' => 'k','ĸ' => 'k',
        'ł' => 'l','ľ' => 'l','ĺ' => 'l','ļ' => 'l','ŀ' => 'l','ñ' => 'n',
        'ń' => 'n','ň' => 'n','ņ' => 'n','ŉ' => 'n','ŋ' => 'n','ò' => 'o',
        'ó' => 'o','ô' => 'o','õ' => 'o','ø' => 'o','ō' => 'o','ő' => 'o',
        'ŏ' => 'o','ŕ' => 'r','ř' => 'r','ŗ' => 'r','ś' => 's','š' => 's',
        'ť' => 't','ù' => 'u','ú' => 'u','û' => 'u','ū' => 'u','ů' => 'u',
        'ű' => 'u','ŭ' => 'u','ũ' => 'u','ų' => 'u','ŵ' => 'w','ÿ' => 'y',
        'ý' => 'y','ŷ' => 'y','ż' => 'z','ź' => 'z','ž' => 'z','Α' => 'A',
        'Ά' => 'A','Ἀ' => 'A','Ἁ' => 'A','Ἂ' => 'A','Ἃ' => 'A','Ἄ' => 'A',
        'Ἅ' => 'A','Ἆ' => 'A','Ἇ' => 'A','ᾈ' => 'A','ᾉ' => 'A','ᾊ' => 'A',
        'ᾋ' => 'A','ᾌ' => 'A','ᾍ' => 'A','ᾎ' => 'A','ᾏ' => 'A','Ᾰ' => 'A',
        'Ᾱ' => 'A','Ὰ' => 'A','ᾼ' => 'A','Β' => 'B','Γ' => 'G','Δ' => 'D',
        'Ε' => 'E','Έ' => 'E','Ἐ' => 'E','Ἑ' => 'E','Ἒ' => 'E','Ἓ' => 'E',
        'Ἔ' => 'E','Ἕ' => 'E','Ὲ' => 'E','Ζ' => 'Z','Η' => 'I','Ή' => 'I',
        'Ἠ' => 'I','Ἡ' => 'I','Ἢ' => 'I','Ἣ' => 'I','Ἤ' => 'I','Ἥ' => 'I',
        'Ἦ' => 'I','Ἧ' => 'I','ᾘ' => 'I','ᾙ' => 'I','ᾚ' => 'I','ᾛ' => 'I',
        'ᾜ' => 'I','ᾝ' => 'I','ᾞ' => 'I','ᾟ' => 'I','Ὴ' => 'I','ῌ' => 'I',
        'Θ' => 'T','Ι' => 'I','Ί' => 'I','Ϊ' => 'I','Ἰ' => 'I','Ἱ' => 'I',
        'Ἲ' => 'I','Ἳ' => 'I','Ἴ' => 'I','Ἵ' => 'I','Ἶ' => 'I','Ἷ' => 'I',
        'Ῐ' => 'I','Ῑ' => 'I','Ὶ' => 'I','Κ' => 'K','Λ' => 'L','Μ' => 'M',
        'Ν' => 'N','Ξ' => 'K','Ο' => 'O','Ό' => 'O','Ὀ' => 'O','Ὁ' => 'O',
        'Ὂ' => 'O','Ὃ' => 'O','Ὄ' => 'O','Ὅ' => 'O','Ὸ' => 'O','Π' => 'P',
        'Ρ' => 'R','Ῥ' => 'R','Σ' => 'S','Τ' => 'T','Υ' => 'Y','Ύ' => 'Y',
        'Ϋ' => 'Y','Ὑ' => 'Y','Ὓ' => 'Y','Ὕ' => 'Y','Ὗ' => 'Y','Ῠ' => 'Y',
        'Ῡ' => 'Y','Ὺ' => 'Y','Φ' => 'F','Χ' => 'X','Ψ' => 'P','Ω' => 'O',
        'Ώ' => 'O','Ὠ' => 'O','Ὡ' => 'O','Ὢ' => 'O','Ὣ' => 'O','Ὤ' => 'O',
        'Ὥ' => 'O','Ὦ' => 'O','Ὧ' => 'O','ᾨ' => 'O','ᾩ' => 'O','ᾪ' => 'O',
        'ᾫ' => 'O','ᾬ' => 'O','ᾭ' => 'O','ᾮ' => 'O','ᾯ' => 'O','Ὼ' => 'O',
        'ῼ' => 'O','α' => 'a','ά' => 'a','ἀ' => 'a','ἁ' => 'a','ἂ' => 'a',
        'ἃ' => 'a','ἄ' => 'a','ἅ' => 'a','ἆ' => 'a','ἇ' => 'a','ᾀ' => 'a',
        'ᾁ' => 'a','ᾂ' => 'a','ᾃ' => 'a','ᾄ' => 'a','ᾅ' => 'a','ᾆ' => 'a',
        'ᾇ' => 'a','ὰ' => 'a','ᾰ' => 'a','ᾱ' => 'a','ᾲ' => 'a','ᾳ' => 'a',
        'ᾴ' => 'a','ᾶ' => 'a','ᾷ' => 'a','β' => 'b','γ' => 'g','δ' => 'd',
        'ε' => 'e','έ' => 'e','ἐ' => 'e','ἑ' => 'e','ἒ' => 'e','ἓ' => 'e',
        'ἔ' => 'e','ἕ' => 'e','ὲ' => 'e','ζ' => 'z','η' => 'i','ή' => 'i',
        'ἠ' => 'i','ἡ' => 'i','ἢ' => 'i','ἣ' => 'i','ἤ' => 'i','ἥ' => 'i',
        'ἦ' => 'i','ἧ' => 'i','ᾐ' => 'i','ᾑ' => 'i','ᾒ' => 'i','ᾓ' => 'i',
        'ᾔ' => 'i','ᾕ' => 'i','ᾖ' => 'i','ᾗ' => 'i','ὴ' => 'i','ῂ' => 'i',
        'ῃ' => 'i','ῄ' => 'i','ῆ' => 'i','ῇ' => 'i','θ' => 't','ι' => 'i',
        'ί' => 'i','ϊ' => 'i','ΐ' => 'i','ἰ' => 'i','ἱ' => 'i','ἲ' => 'i',
        'ἳ' => 'i','ἴ' => 'i','ἵ' => 'i','ἶ' => 'i','ἷ' => 'i','ὶ' => 'i',
        'ῐ' => 'i','ῑ' => 'i','ῒ' => 'i','ῖ' => 'i','ῗ' => 'i','κ' => 'k',
        'λ' => 'l','μ' => 'm','ν' => 'n','ξ' => 'k','ο' => 'o','ό' => 'o',
        'ὀ' => 'o','ὁ' => 'o','ὂ' => 'o','ὃ' => 'o','ὄ' => 'o','ὅ' => 'o',
        'ὸ' => 'o','π' => 'p','ρ' => 'r','ῤ' => 'r','ῥ' => 'r','σ' => 's',
        'ς' => 's','τ' => 't','υ' => 'y','ύ' => 'y','ϋ' => 'y','ΰ' => 'y',
        'ὐ' => 'y','ὑ' => 'y','ὒ' => 'y','ὓ' => 'y','ὔ' => 'y','ὕ' => 'y',
        'ὖ' => 'y','ὗ' => 'y','ὺ' => 'y','ῠ' => 'y','ῡ' => 'y','ῢ' => 'y',
        'ῦ' => 'y','ῧ' => 'y','φ' => 'f','χ' => 'x','ψ' => 'p','ω' => 'o',
        'ώ' => 'o','ὠ' => 'o','ὡ' => 'o','ὢ' => 'o','ὣ' => 'o','ὤ' => 'o',
        'ὥ' => 'o','ὦ' => 'o','ὧ' => 'o','ᾠ' => 'o','ᾡ' => 'o','ᾢ' => 'o',
        'ᾣ' => 'o','ᾤ' => 'o','ᾥ' => 'o','ᾦ' => 'o','ᾧ' => 'o','ὼ' => 'o',
        'ῲ' => 'o','ῳ' => 'o','ῴ' => 'o','ῶ' => 'o','ῷ' => 'o','А' => 'A',
        'Б' => 'B','В' => 'V','Г' => 'G','Д' => 'D','Е' => 'E','Ё' => 'E',
        'Ж' => 'Z','З' => 'Z','И' => 'I','Й' => 'I','К' => 'K','Л' => 'L',
        'М' => 'M','Н' => 'N','О' => 'O','П' => 'P','Р' => 'R','С' => 'S',
        'Т' => 'T','У' => 'U','Ф' => 'F','Х' => 'K','Ц' => 'T','Ч' => 'C',
        'Ш' => 'S','Щ' => 'S','Ы' => 'Y','Э' => 'E','Ю' => 'Y','Я' => 'Y',
        'а' => 'A','б' => 'B','в' => 'V','г' => 'G','д' => 'D','е' => 'E',
        'ё' => 'E','ж' => 'Z','з' => 'Z','и' => 'I','й' => 'I','к' => 'K',
        'л' => 'L','м' => 'M','н' => 'N','о' => 'O','п' => 'P','р' => 'R',
        'с' => 'S','т' => 'T','у' => 'U','ф' => 'F','х' => 'K','ц' => 'T',
        'ч' => 'C','ш' => 'S','щ' => 'S','ы' => 'Y','э' => 'E','ю' => 'Y',
        'я' => 'Y','ð' => 'd','Ð' => 'D','þ' => 't','Þ' => 'T','ა' => 'a',
        'ბ' => 'b','გ' => 'g','დ' => 'd','ე' => 'e','ვ' => 'v','ზ' => 'z',
        'თ' => 't','ი' => 'i','კ' => 'k','ლ' => 'l','მ' => 'm','ნ' => 'n',
        'ო' => 'o','პ' => 'p','ჟ' => 'z','რ' => 'r','ს' => 's','ტ' => 't',
        'უ' => 'u','ფ' => 'p','ქ' => 'k','ღ' => 'g','ყ' => 'q','შ' => 's',
        'ჩ' => 'c','ც' => 't','ძ' => 'd','წ' => 't','ჭ' => 'c','ხ' => 'k',
        'ჯ' => 'j','ჰ' => 'h'
        );
        $str = str_replace( array_keys( $transliteration ),
                            array_values( $transliteration ),
                            $str);
        return $str;
    }

    public static function acentosHtml($text){
        $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
        return $text;
    }

    public static function onlyUri($string){
        if(preg_match("/\?(.*)/i",$string)){
            preg_match("/(.*)\?(.*)/i",$string,$nuevo);
            return $nuevo[1];
        }else
            return $string;
    }

    public static function whiteListeIp(){

        return true;

        $form_uris = array(
                'ecommerce.domain.com'
        );

        if(isset($_SERVER['HTTP_REFERER']) OR isset($_SERVER['SERVER_NAME'])) {
            if(!in_array($_SERVER['HTTP_REFERER'], $form_uris))
                return false;
        }
        return true;
    }

    public static function procesoAcentos($string){
        if(!self::whiteListeIp())
                return false;

        $str = utf8_encode(self::noSoloAcentos(self::getDataAll($string)));
        $str = htmlentities(self::getDataAll($string), ENT_QUOTES,'UTF-8');
        return $str;
    }

    public static function procesoAcentosNormal($string){
	    if(!self::whiteListeIp())
            return false;

        $str = htmlentities($string, ENT_QUOTES,'UTF-8');
        return $str;
    }

    public static function regresoAcentos($param){
	    return html_entity_decode($param);
    }

    public static function creaSession($user){
        session_start();
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['profile_id'] = $user->profile_id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['photo_url'] = $user->photo_url;
    }

    public static function verificaUsuario(){
        session_start();

        if(!isset($_SESSION['user_id'])){
            header('Location: /semovi/login/');
            exit();
        }

    }

    public static function destruyeSession(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: /semovi/login/");
    }
  
    public static function getSession($value){
        session_start();
        return ($_SESSION[$value] != '') ? $_SESSION[$value] : '';
    }

    public static function generaPassAleatorio(){
        //Se define una cadena de caractares.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);
         
        //Se define la variable que va a contener la contraseña
        $pass = "";
        //Se define la longitud de la contraseña
        $longitudPass=10;
         
        //Creamos la contraseña
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
         
            //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    public static function cleanPost($val){
        if (!isset($_POST[$val])) {
            $_POST[$val] = NULL;
            return $_POST[$val] = trim(htmlentities($_POST[$val], ENT_QUOTES, 'UTF-8'));
        } elseif (!isset($_GET[$val])) {
            $_GET[$val] = NULL;
            return $_GET[$val] = trim(htmlentities($_GET[$val], ENT_QUOTES, 'UTF-8'));
        }

        /*$_POST[$val] = trim(htmlentities($_POST[$val], ENT_QUOTES, 'UTF-8'));
        $_GET[$val] = trim(htmlentities($_GET[$val], ENT_QUOTES, 'UTF-8'));*/
    }

    public static function getUrlToTkeys($REDIRECT_SCRIPT_URL){
        $explode = explode("/", $REDIRECT_SCRIPT_URL);
        if(count($explode) >= 3){
            $val = $explode['1'];
        }else{
            $explode2 = explode("?", $REDIRECT_SCRIPT_URL);
            $val = $explode2['0'];
        }
        return $val;
    }

    public static function validateParams(){
        $args = func_get_args();
        // print_r($args);
        foreach ($args as $key => $value) {
            if ($value == "") {
                return false;
            }
        }
        return true;
    }
   
    public static function cambiaAcentos($cadena) {
        $cadenaa = str_replace("á", "&aacute;", $cadena);
        $cadenae = str_replace("é", "&eacute;", $cadenaa);
        $cadenai = str_replace("í", "&iacute;", $cadenae);
        $cadenao = str_replace("ó", "&oacute;", $cadenai);
        $cadenau = str_replace("ú", "&uacute;", $cadenao);
        $cadenaA = str_replace("Á", "&Aacute;", $cadenau);
        $cadenaE = str_replace("É", "&Eacute;", $cadenaA);
        $cadenaI = str_replace("Í", "&Iacute;", $cadenaE);
        $cadenaO = str_replace("Ó", "&Oacute;", $cadenaI);
        $cadenaU = str_replace("Ú", "&Uacute;", $cadenaO);
        return $cadenaU;
    }


    public static function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function setBase64Img($path){
 
        // obtenemos la extensión
        $type = pathinfo($path, PATHINFO_EXTENSION);
        
        // obtenemos el contenido de la imagen
        $data = file_get_contents($path);
        
        // generamos la cadena
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data);
        
        return $base64;
    }
    
}




