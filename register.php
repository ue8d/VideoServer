<?php
    session_start();
    require "function.php";
    if(isset($_SESSION["id"])) {
        header('Location: /');
    }
?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>ue8d's Videos</title>
        <link rel="stylesheet" type="text/css" href="./CSS/index.css">
    </head>
    <body style="background-color:white">
        <!-- ヘッダー読み込み -->
        <?php include_once "./header.php" ?>

        <div class="main">
        <?php
        if((isset($_POST['userName'])) && (isset($_POST['password']))){
            //DB接続
            $dbh = get_pdo();
            // SQL
            $sql = 'SELECT * FROM users WHERE userName = :userName';
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':userName', $_POST['userName'], PDO::PARAM_STR);
            $prepare->execute();
            //連想配列として保存
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
            // 結果を出力
            $id = array_column($result, "id");

            //ユーザーIDが使用可能か確認
            if(empty($id)){
                $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $insertSql = 'INSERT INTO users (userName, password) VALUES (:userName, :password)';
                $insertPrepare = $dbh->prepare($insertSql);
                $insertPrepare->bindValue(':userName', $_POST['userName'], PDO::PARAM_STR);
                $insertPrepare->bindValue(':password', $hash, PDO::PARAM_STR);
                $insertPrepare->execute();
                echo "登録が完了しました";
            }else {
                echo "すでにユーザーIDが使われています。";
            }
        }
        ?>
        <form method="post" action="register.php" class="search_container">
            <p><input type="text" name="userName" size="25" placeholder="ログインID"></P>
            <p><input type="password" name="password" size="25" placeholder="パスワード"></P>
            <input type="submit" value="登録">
        </form>
        </div>

        <footer class="index">
        <p>© All rights reserved by ue8d.</p>
        </footer>
    </body>
</html>