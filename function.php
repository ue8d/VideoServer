<?php
    session_start();
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

    function get_all_video_list() {
        //DB接続
        $dbh = get_pdo();
        // SQL
        $sql = 'SELECT * FROM thumb';
        $prepare = $dbh->prepare($sql);
        $prepare->execute();
        //連想配列として保存
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function get_user_video_list() {
        $dbh = get_pdo();
        $hidenVideoSql = 'SELECT
                            thumb.id
                            ,thumb.videoName
                            ,thumb.videoPath
                            ,thumb.thumbPath
                            ,alreadySeenList.userId
                            ,alreadySeenList.thumbId
                            ,alreadySeenList.flag
                        FROM
                            thumb
                        LEFT JOIN
                            alreadySeenList on thumb.id=alreadySeenList.thumbId
                        WHERE
                            alreadySeenList.thumbId is NULL or thumb.id <> alreadySeenList.thumbId';
        $hidenVideoPrepare = $dbh->prepare($hidenVideoSql);
        // $hidenVideoPrepare->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
        $hidenVideoPrepare->execute();
        $hidenVideoResult = $hidenVideoPrepare->fetchAll(PDO::FETCH_ASSOC);
        return $hidenVideoResult;
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