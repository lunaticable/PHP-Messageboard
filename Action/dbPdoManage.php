<?php
class dbPdoManage
{
    private $conn = NULL;
    private $mess = '';

    public function __construct(
        $host = 'localhost:3308',
        $user = 'root',
        $pwd = '',
        $dbname = 'chatsystem',
        $charset = 'utf8'
        )
        {
        try{
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname",$user,$pwd);
            $this->conn->exec("set names ".$charset);
            $this->mess .= $this->setFormat('连接数据库服务器及选择数据库成功', true);
        }
        // catch (PDOException $e) { 
        //     echo '数据库连接失败： ' . $e->getMessage(); 
        // }
        catch(PDOException $error){
            echo "错误";
            $this->mess .= $this->setFormat('连接数据库服务器及选择数据库失败', false);
        }
    }
    public function execsql1($sql){
        $result = $this->conn->exec($sql);
        if($result !== false){

            $this->mess .= $this->setFormat('执行sql成功', true);
            
            return true;    
        }
        else{
            $this->mess .= $this->setFormat('执行sql失败', false);
            return false;
        }
    }
    public function execSql($sql){
        $sql = trim(strtolower($sql));
        $pre = '/^insert|update|delete|ALTER/';
        $r = preg_match($pre,$sql);
        if($r == 0){
            $this->mess .= $this->setFormat('传入的sql语句不合法', false);
            return false;
        }
        $this->mess .= $this->setFormat('传入的sql语句合法', true);
        $result = $this->conn->exec($sql);
        if($result !== false){

            $this->mess .= $this->setFormat('执行sql成功', true);
            
            return true;    
        }
        else{
            $this->mess .= $this->setFormat('执行sql失败', false);
            return false;
        }
    }

    public function getOneData($sql){
        $sql = trim(strtolower($sql));
        $pre = '/^select/';
        $r = preg_match($pre,$sql);
        if($r == 0){
            $this->mess .= $this->setFormat('传入的sql语句不合法', false);
            return false;
        }
        $this->mess .= $this->setFormat('传入的sql语句合法', true);
        $result = $this->conn->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $result->fetch();
        $result = NULL;
        if(is_array($rs) && !empty($rs)){
            $this->mess .= $this->setFormat('查询数据成功', true);
            return $rs;
        }
        else{
            $this->mess .= $this->setFormat('查询数据失败', false);
            return array('没有查询到数据');
        }
    }
    public function getMoreData($sql){
        $sql = trim(strtolower($sql));
        $pre = '/^select/';
        $r = preg_match($pre,$sql);
        if($r == 0){
            $this->mess .= $this->setFormat('传入的sql语句不合法', false);
            return false;
        }
        $this->mess .= $this->setFormat('传入的sql语句合法', true);
        $result = $this->conn->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $rs = $result->fetchAll();
        $result = NULL;
        if(is_array($rs) && !empty($rs)){
            $this->mess .= $this->setFormat('查询数据成功', true);
            return $rs;
        }
        else{
            $this->mess .= $this->setFormat('查询数据失败', false);
            return $rs;
            // return 1;
        }
    }
    public function closeConn(){
        $this->conn = NULL;
    }
    //调试样式
    private function setFormat($content,$flag){
        if($flag == true){
            return "<li style='color:green;font-size:12px;font-weight:bold;'>".$content."</li><br>";
        }
        if($flag == false){
            return "<li style='color:red;font-size:12px;font-weight:bold;'>".$content."</li><br>";
        }
    } 

    public function getMess($sql){
        return '<div style=color:black;font-size:14px;>调试信息如下：</div><ol>'.$this->mess.'</ol>';
    }

    #对话框
    public function showMessage($m,$u){
        echo "<script type='text/javascript'>
            alert('".$m."');location.href='".$u."';
            </script>";
    }

}

$db = new dbPdoManage();

?>