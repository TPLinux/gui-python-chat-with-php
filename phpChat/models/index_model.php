<?php

class Index_Model extends Model{
    
    public function __construct(){
        parent::__construct();
    }

    public function checkUser($nickname, $password){
        $check_info = $this->db->table("chat_u")->at("where u_name = '{$nickname}' and u_pass = '{$password}'")->select('u_id');
        if($this->db->rowCount > 0)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function newMsg($nickname, $msg){
        $this->db->table('msgs')->insert("(msg_from,msg_content) values('{$msg}','{$nickname}')");
    }

    public function getAllMsgs(){
        $msgs = $this->db->table('msgs')->at("order by msg_id asc")->select("*");
        if($this->db->rowCount > 0 ){
            return $msgs;
        }else{
            return false;
        }
    }

}
?>
