<?php
    require "function.php";
    if (!(isset($_SESSION['id']))) {
        header('Location: login.php');
    }
    # ビデオの非表示取り消し処理
    if(isset($_POST['restoreHiddenVideo'])) {
        $restoreHiddenVideo = htmlspecialchars($_POST['restoreHiddenVideo']);
        restore_hidden_video($restoreHiddenVideo);
    }
?>
<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>MyPage | ue8d's Videos</title>
        <link rel="stylesheet" type="text/css" href="./CSS/index.css">
    </head>
    <body style="background-color:white">
        <!-- ヘッダー読み込み -->
        <?php include_once "./header.php" ?>

        <div class="main">
        <p><h2>ユーザー情報</h2></p>
        <p>ユーザー名：<?php echo $_SESSION['userName'] ?></p>
        <p>ユーザーランク：<?php echo $msg = ($_SESSION['role'] == 999) ? '管理者' : '一般ユーザー' ?></p>
        <p>非表示にしたVOD一覧</p>
        <div class="container">
        <?php
            // ログインユーザー判定
            $result = get_user_hidden_video_list($_SESSION['id']);

            $id = array_column($result, "id");
            $videoName = array_column($result, "videoName");
            $videoPath = array_column($result, "videoPath");
            $thumbPath = array_column($result, "thumbPath");

            for ($i=0; $i < count($id); $i++) {
            ?>
                <div class="item">
                <p class="title">
                    <a href="./02/vod.php?videoPass=<?php echo $videoPath[$i]; ?>&videoName=<?php echo $videoName[$i]; ?>"><?php echo $videoName[$i]; ?><br>
                    <img src="<?php echo $thumbPath[$i]; ?>" alt="<?php echo $videoName[$i]."　サムネ"; ?>"></a>
                    <?php
                    echo '<form method="post" action="./mypage.php">';
                        echo '<input type="hidden" name="restoreHiddenVideo" value="'. $id[$i] .'">';
                        echo '<input type="submit" value="元に戻す">';
                    echo '</form>';
                echo '</p>';
                echo '</div>';
            }
            echo '</div>';
        ?>
        </div>

        <footer class="index">
        <p>© All rights reserved by ue8d.</p>
        </footer>
    </body>
</html>