<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>DBInsert | ue8d's Videos</title>
        <link rel="stylesheet" type="text/css" href="./CSS/index.css">
    </head>
    <body style="background-color:white">
        <!-- ヘッダー読み込み -->
        <?php include_once "./header.php" ?>

        <div class="main">
        <p>データベースの更新</p>
        <?php
            require "core/config.php";
            try {
            $dbh = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
            echo "接続失敗: " . $e->getMessage() . "\n";
            exit();
            }

            //sql作成
            $insertSql = '
                    INSERT INTO thumb (
                        videoName
                        ,videoPath
                        ,thumbPath
                    ) VALUES (
                        :videoName
                        ,:videoPath
                        ,:thumbPath
                    )
            ';
            $insertPrepare = $dbh->prepare($insertSql);

            //サムネイル削除
            //shell_exec("find -name '*.jpg' | xargs rm");

            //挿入済情報確認
            $sql = 'SELECT * FROM thumb';
            $prepare = $dbh->prepare($sql);
            $prepare->execute();
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
            $dbVideoName = array_column($result, "videoName");

            //ファイル名用
            foreach(glob('encVideo/{*.m3u8}',GLOB_BRACE) as $file){
                if(is_file($file)){
                $insertFlag = false;
                $videoName = substr($file,28,-5);
                for ($j=0; $j < count($dbVideoName); $j++) {
                    if ($dbVideoName[$j] == $videoName) {
                    $insertFlag = true;
                    break;
                    }
                }
                if(!$insertFlag){
                    $videoPath = $file;
                    $thumbName = substr($file,9,18);
                    shell_exec("ffmpeg -i ". $videoPath ." -ss 6 -vframes 1 -f image2 -s 320x240 ". $thumbName .".jpg");
                    $thumbPath = $thumbName.".jpg";
                    $insertPrepare->bindValue(':videoName', $videoName, PDO::PARAM_STR);
                    $insertPrepare->bindValue(':videoPath', $videoPath, PDO::PARAM_STR);
                    $insertPrepare->bindValue(':thumbPath', $thumbPath, PDO::PARAM_STR);
                    $insertPrepare->execute();
                }
                }
            }

            //デバック用
            // $sql = 'SELECT * FROM thumb';
            // $prepare = $dbh->prepare($sql);
            // $prepare->execute();
            // $result2 = $prepare->fetchAll(PDO::FETCH_ASSOC);
            // var_dump($result2);

            //デバック時には無効にする
            header('Location: /');
        ?>
        </div>

        <footer class="index">
        <p>© All rights reserved by ue8d.</p>
        </footer>
    </body>
</html>