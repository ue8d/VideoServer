<?php
    session_start();
    require "function.php";
    # 検索結果表示用
    if(isset($_GET['keyword'])) {
        $keyword = htmlspecialchars($_GET['keyword']);
        $result = get_search_result($keyword);
    }else {
        $keyword = null;
    }
    # ビデオの非表示処理
    if(isset($_POST['hiddenvideo'])) {
        $hiddenvideo = htmlspecialchars($_POST['hiddenvideo']);
        hide_video($hiddenvideo);
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
            //ログアウト時にメッセージ表示
            if (isset($_SESSION['logoutMsg'])) {
            echo 'ログアウトしました。';
            unset($_SESSION['logoutMsg']);
            }
        ?>
        <form method="get" action="./" class="search_container">
            <input type="text" name="keyword" size="25" placeholder="キーワード検索">
            <input type="submit" value="検索">
        </form>
        <p>VOD一覧</p>
        <div class="container">
        <?php
            if($keyword != null) {
            $id = array_column($result, "id");
            $videoName = array_column($result, "videoName");
            $videoPath = array_column($result, "videoPath");
            $thumbPath = array_column($result, "thumbPath");
            for ($i=0; $i < count($id); $i++) {
            ?>
            <div class="item">
                <p class="title" style="text-wrap:normal;">
                    <a href="./02/vod.php?videoPass=<?php echo $videoPath[$i]; ?>&videoName=<?php echo $videoName[$i]; ?>"><?php echo $videoName[$i]; ?><br>
                    <img src="<?php echo $thumbPath[$i]; ?>" alt="<?php echo $videoName[$i]."　サムネ"; ?>"></a>
                </p>
            </div>
            <?php
            }
            //検索なし
            if(empty($videoName)){
                echo "該当するものがありませんでした";
            }
            }else{
            $dbh = get_pdo();

            // SQL
            $sql = 'SELECT * FROM thumb';
            $prepare = $dbh->prepare($sql);
            $prepare->execute();
            //連想配列として保存
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
            // 結果を出力
            $id = array_column($result, "id");
            $videoName = array_column($result, "videoName");
            $videoPath = array_column($result, "videoPath");
            $thumbPath = array_column($result, "thumbPath");

            // ログインユーザー用
            if(isset($_SESSION['id'])){
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
                $id = array_column($hidenVideoResult, "id");
                $videoName = array_column($hidenVideoResult, "videoName");
                $videoPath = array_column($hidenVideoResult, "videoPath");
                $thumbPath = array_column($hidenVideoResult, "thumbPath");
            }
            ?>
            <?php
            for ($i=0; $i < count($id); $i++) {
            ?>
                <div class="item">
                <p class="title" style="text-wrap:normal;">
                    <a href="./02/vod.php?videoPass=<?php echo $videoPath[$i]; ?>&videoName=<?php echo $videoName[$i]; ?>"><?php echo $videoName[$i]; ?><br>
                    <img src="<?php echo $thumbPath[$i]; ?>" alt="<?php echo $videoName[$i]."　サムネ"; ?>"></a>
                    <?php
                    if (isset($_SESSION['id'])) {
                    echo '<form method="post" action="./">';
                        echo '<input type="hidden" name="hiddenvideo" value="'. $id[$i] .'">';
                        echo '<input type="submit" value="非表示にする">';
                    echo '</form>';
                    }
                    ?>
                </p>
                </div>
            <?php
            }
            ?>
            </div>
            <?php
            }?>
        </div>

        <footer class="index">
        <p>© All rights reserved by ue8d.</p>
        </footer>
    </body>
</html>