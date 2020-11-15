<?php
    function get_pdo() {
        try {
            require "core/config.php";
            return $dbh = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
        }
    }

    function get_search_result($inputKeyword) {
        //DB接続
        $dbh = get_pdo();
        // SQL
        $sql = 'SELECT * FROM thumb WHERE videoName LIKE :keyword';
        $prepare = $dbh->prepare($sql);
        $prepare->bindValue(':keyword', "%".$inputKeyword."%", PDO::PARAM_STR);
        $prepare->execute();
        //連想配列として保存
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function hide_video($hiddenvideo) {
        //DB接続
        $dbh = get_pdo();
        // SQL
        $sql = "INSERT INTO alreadySeenList (thumbId,userId,flag) VALUES (:thumbId,:userId,:flag)";
        $prepare = $dbh->prepare($sql);
        $prepare->bindValue(':thumbId', $hiddenvideo, PDO::PARAM_STR);
        $prepare->bindValue(':userId', $_SESSION["id"], PDO::PARAM_STR);
        $prepare->bindValue(':flag', '1', PDO::PARAM_STR);
        $prepare->execute();

        return TRUE;
    }