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

        //テーブルドロップ
        $sql = 'DROP TABLE IF EXISTS thumb';
        $prepare = $dbh->prepare($sql);
        $prepare->execute();

        //テーブル作成
        $sql = 'CREATE TABLE thumb (
            id int(11) AUTO_INCREMENT,
            videoName varchar(255) NOT NULL,
            videoPath varchar(255) NOT NULL,
            thumbPath varchar(255),
            PRIMARY KEY (id)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8';
        $prepare = $dbh->prepare($sql);
        $prepare->execute();

        //sql作成
        $sql = '
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
        $prepare = $dbh->prepare($sql);

        //サムネイル削除
        shell_exec("find -name '*.jpg' | xargs rm");

        //ファイル名用
        $id=0;
        foreach(glob('encVideo/{*.m3u8}',GLOB_BRACE) as $file){
            if(is_file($file)){
                $videoName = substr($file,28,-5);
                $videoPath = $file;
                shell_exec("ffmpeg -i ". $videoPath ." -ss 6 -vframes 1 -f image2 -s 320x240 ". $id .".jpg");
                $thumbPath = $id.".jpg";
                $prepare->bindValue(':videoName', $videoName, PDO::PARAM_STR);
                $prepare->bindValue(':videoPath', $videoPath, PDO::PARAM_STR);
                $prepare->bindValue(':thumbPath', $thumbPath, PDO::PARAM_STR);
                $prepare->execute();
                $id++;
            }
        }

        //デバック用
        // $sql = 'SELECT * FROM thumb';
        // $prepare = $dbh->prepare($sql);

        // $prepare->execute();

        // $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
        //デバック時には無効にする
        header('Location: /');
      ?>
    </div>

    <footer class="index">
      <p>© All rights reserved by ue8d.</p>
    </footer>
  </body>
</html>