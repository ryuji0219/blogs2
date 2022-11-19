<?php

    require_once "./classes/userLogic.php";
    $err = [];

    if (!$name = filter_input(INPUT_POST,'name')){
        $err[] = 'ユーザ名を入力して下さい';
    }

    if (!$email = filter_input(INPUT_POST,'email')){
        $err[] = 'メールアドレスを入力して下さい';
    }


        $pass = filter_input(INPUT_POST,'password');

        if (!preg_match('/\A[a-z\d]{3,100}+\z/i',$pass)){
            $err[] = 'パスワードは英数字3文字以上で入力して下さい';
    
        }


    $pass2 = filter_input(INPUT_POST,'pass2');

  #  echo $pass2 . <br>;

    if($pass !== $pass2){
        $err[] = '入力パスワードが一致しません。';
    }

    if(count($err) === 0){
        //ユーザ登録処理
        $hasCreated = UserLogic::createdUser($_POST);
        if(!$hasCreated){
            $err[] = '登録に失敗しました。';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了画面</title>
</head>
<body>
    <?php if (count($err) > 0) : ?>
        <?php foreach($err as $e) : ?>
            <p><?php echo $e ?></p>
        <?php endforeach ?>        
    <?php else : ?>        
        <p2>登録完了</p>
    <?php endif ?>        
    <a href = "MemberCreate">戻る</a>
</body>
</html>