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

    function get_user_video_list($userId) {
        $dbh = get_pdo();
        // ビデオ一覧の取得
        $videoListSql = 'select * from thumb';
        $videoListPrepare = $dbh->prepare($videoListSql);
        $videoListPrepare->execute();
        $videoListResult = $videoListPrepare->fetchAll(PDO::FETCH_ASSOC);
        $videoListResultId = array_column($videoListResult, "id");
        $videoListResultVideoName = array_column($videoListResult, "videoName");
        $videoListResultVideoPath = array_column($videoListResult, "videoPath");
        $videoListResultThumbPath = array_column($videoListResult, "thumbPath");

        $dbh = get_pdo();
        // 非表示にするビデオ一覧の取得
        $hiddenVideoSql = 'select * from alreadySeenList where userId = :id and flag = true';
        $hiddenVideoPrepare = $dbh->prepare($hiddenVideoSql);
        $hiddenVideoPrepare->bindValue(':id', $userId, PDO::PARAM_STR);
        $hiddenVideoPrepare->execute();
        $hiddenVideoResult = $hiddenVideoPrepare->fetchAll(PDO::FETCH_ASSOC);
        $hiddenVideoResultThumbId = array_column($hiddenVideoResult, "thumbId");

        // リターン用配列の用意
        $returnVideoList = array();
        // 配列の添え字
        $suffix = 0;

        for ($i=0; $i < count($videoListResultId); $i++) {
            $flag = true;
            for ($j=0; $j < count($hiddenVideoResultThumbId); $j++) {
                if ($videoListResultId[$i] == $hiddenVideoResultThumbId[$j]) {
                    $flag = false;
                    break;
                }
            }
            if ($flag) {
                $returnVideoList[$suffix]['id'] = $videoListResultId[$i];
                $returnVideoList[$suffix]['videoName'] = $videoListResultVideoName[$i];
                $returnVideoList[$suffix]['videoPath'] = $videoListResultVideoPath[$i];
                $returnVideoList[$suffix]['thumbPath'] = $videoListResultThumbPath[$i];
                $suffix++;
            }
        }

        return $returnVideoList;
    }

    function hide_video($hiddenvideo): void {
        //DB接続
        $dbh = get_pdo();
        // SQL
        $sql = "INSERT INTO alreadySeenList (thumbId,userId,flag) VALUES (:thumbId,:userId,:flag)";
        $prepare = $dbh->prepare($sql);
        $prepare->bindValue(':thumbId', $hiddenvideo, PDO::PARAM_STR);
        $prepare->bindValue(':userId', $_SESSION["id"], PDO::PARAM_STR);
        $prepare->bindValue(':flag', '1', PDO::PARAM_STR);
        $prepare->execute();
    }