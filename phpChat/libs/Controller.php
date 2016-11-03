<?php
class Controller {
    
    public function __construct(){
        $this->view = new View();
        @session_start();
    }

    // يمكن استخدام هذه الدالة في حال كان الباراميتر الاول الممرر
    // للدالة يساوي ( لا شيئ )
    // وهذا يؤدي الى تحويله للصفحة السابقة بدون استخدام الباراميتر
    public function back($arg){
        
        if($arg[0] == null){
            header("Location: /".$url[0]."/".$url[1]);
        }
    }


    public function loadModel($name){
        $path = "models/" . strtolower($name) . "_model.php";

        if(file_exists($path)){
            require_once($path);
            $modelName = ucfirst($name) . "_Model";
            $this->model = new $modelName();
        }
    }

    /* هذه الدالة تستخدم في حال ما اذا خالف المتغير الشروط المحدد
     * يحول الزائر الي ال URL الموجود في ملف config/pathes.php
     */
    public function withRule($str,$rule){
        
        if(!preg_match($rule,$str)){
            return false;
        }else{
            return true;
        }
    }

    public function redirect($to){
        header("Location: " . $to);
    }

    public function protect($var){
        if(get_magic_quotes_gpc()){
            return addslashes(stripslashes($var));
        }else{
            return addslashes($var);
        }
    }

    /* speadly function to do CURL request (post and get) */
    public function curl_do_post($url,$data,$cf,$host,$h = false){
        // curl initializing
        $ch = curl_init();

        // http header request
        if($h === false)
            $h = [
                'Host:' . $host,
                'User-Agent:Mozilla/5.0 (X11; Linux x86_64; rv:"45.0) Gecko/20100101 Firefox/45.0"',
                'Accept:"text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"',
                'Accept-Language:"en-US,en;q=0.5"',
                'Accept-Encoding:"gzip, deflate"',
                'Connection:"keep-alive"'
            ];
        
        // set options of curl
        curl_setopt_array($ch,array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => $cf, // cookie file
            CURLOPT_COOKIEFILE => $cf,
            CURLOPT_HTTPHEADER => $h,
            CURLOPT_USERAGENT => $h[1],
            CURLOPT_POST => true,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $data
        ));
        // prevent any out put
        ob_start(); 
        $output = curl_exec($ch);
        ob_end_clean();

        // close curl proc
        curl_close($ch);
        unset($ch);

        // return the out put of request response
        return $output;
    }

    public function curl_do_get($url,$cf = false){
        // curl initializing
        $ch = curl_init();

        // if using cookie
        if($cf != false)
            curl_setopt($ch,CURLOPT_COOKIEFILE,$cf);
        
        // set options of curl
        curl_setopt_array($ch,array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'User-Agent:Mozilla/5.0 (X11; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0',
            CURLOPT_URL => $url
        ));
        
        $output = curl_exec($ch);

        curl_close($ch);
        unset($ch);

        // return the out put of request response
        return $output; 
    }
    
    // check post values if empty 
    public function checkPost($postName){
        if(isset($_POST[$postName])){
            if(!empty(trim($_POST[$postName])))
                return true;
            else
                return false;
        }else
            return false;
    }

    // check get values if empty 
    public function checkGet($getName){
        if(isset($_GET[$getName])){
            if(!empty(trim($_GET[$getName])))
                return true;
            else
                return false;
        }else
            return false;
    }

}   
?>
