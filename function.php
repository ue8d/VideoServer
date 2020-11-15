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
        $keyword = htmlspecialchars($inputKeyword);

        //DB接続
        $dbh = get_pdo();
        // SQL
        $sql = 'SELECT * FROM thumb WHERE videoName LIKE :keyword';
        $prepare = $dbh->prepare($sql);
        $prepare->bindValue(':keyword', "%".$keyword."%", PDO::PARAM_STR);
        $prepare->execute();
        //連想配列として保存
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }