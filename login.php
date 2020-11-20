<?php
    session_start();
    require "function.php";
    if(isset($_SESSION["id"])) {
        header('Location: /');
    }
    if((isset($_POST['userName'])) && (isset($_POST['password']))){
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
        $userName = array_column($result, "userName");
        $password = array_column($result, "password");
        $role = array_column($result, "role");
        $hash = $password[0];

        //パスワード確認
        //$hash = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
        if (password_verify($_POST['password'], $hash)) {
            $_SESSION['id'] = $id[0];
            $_SESSION['userName'] = $userName[0];
            $_SESSION['role'] = $role[0];
            header('Location: /');
        }else {
            echo "ユーザーIDまたはパスワードが違います";
        }
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
            <p><h2>ログインフォーム</h2></p>
            <form method="post" action="login.php" class="search_container">
                <label><p>ログインID：<input type="text" name="userName" size="25" placeholder="ログインID"></P></label>
                <label><p>パスワード：<input type="password" name="password" size="25" placeholder="パスワード"></P></label>
                <input type="submit" value="ログイン">
            </form>
        </div>

        <footer class="index">
        <p>© All rights reserved by ue8d.</p>
        </footer>
    </body>
</html>