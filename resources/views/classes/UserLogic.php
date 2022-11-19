<?php
require_once './classes/dbconnect.php';

class UserLogic{
    /**
     *  ユーザ登録
     */
    public static function createdUser($userData)
    {

#print $userData['email'] . '<br>';
#print $userData['password'] . '<br>';

        $result=false;
        $sql = 'INSERT INTO users (name,email,
            password) VALUE(?,?,?)';

        $arr = [];
        $arr[] = $userData['name'];
        $arr[] = $userData['email'];
        $arr[] = md5($userData['password']);
#        $arr[] = password_hash($userData['password'],PASSWORD_DEFAULT);
#        $arr[] = $pass;

         try{
            $stmt=connect()->prepare($sql);
    #        $stmt=$dbh->prepare($sql);
            $resut=$stmt->execute($arr);
            return $resut;
        } catch(\Exception $e){
            print '失敗:' . $e . '<br>';
            return $result;
        }
    }

    // ログイン処理
    public static function login($email,$pass)
    {
        $result=false;

        $user = self::getUserByEmail($email);
        if (!$user){
            $_SESSION['msg'] = 'メールアドレスが登録されてません。';
            return false;
        }

 
        print 'email:' . $email . '<br>';
       print 'DB1:' . $user['name'] . '<br>';
        print 'DB2:' .  $user['password'] . '<br>';
        print 'DB3:' .  $user['email'] . '<br>';

        print 'pass:' . $pass . '<br>';
        $hash_pass =$user['password'];
        print 'hash_pass:' . $hash_pass . '<br>';

    #    if(password_verify('rasmuslerdorf', $hash)){
        if(password_verify($pass, $hash_pass)){
            session_regenerate_id(true);
#            $_SESSION['login_user'] = $user;
            return true;
        }
        else{
            dd($user);
        }
        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $false;
    }

    // ユーザ情報取得処理
    public static function getUserByEmail($email)
    {
        $result=false;

#        $sql = 'SELECT name,password from users
        $sql = 'SELECT * from users where email = ?';
        $arr = [];
        $arr[] = $email;

         try{
            $stmt=connect()->prepare($sql);
            $stmt->execute($arr);
            $user = $stmt->fetch();
            return $user;
        } catch(\Exception $e){
            print '失敗:' . $e . '<br>';
            return $result;
        }

    }

}