<?php $title = isset($_GET['videoName']) ? htmlspecialchars($_GET['videoName']) : "読み込めませんでした"; ?>
<DOCTYPE html>
<html lang="ja">
    <head>
        <title>
            VOD ”<?php echo $title ?>” | ue8d's Videos
        </title>

        <link href="./video-js.min.css" rel="stylesheet">
        <link href="../CSS/index.css" rel="stylesheet">

        <script src="./hls.min.js"></script>
        <script type="text/javascript">
            var source = "<?php echo htmlspecialchars($_GET['videoPass']); ?>";
        </script>
    </head>
    <body style="background-color:white">
        <?php include_once "../header.php" ?>
        <p class="title">
            <?php echo $title; ?>
        </p>
        <div class="vod">
            <video id="video" class="video-js vjs-default-skin vjs-default-centered" width="640" height="480" controls>
            <script type="text/javascript">
                // 変換した動画ファイルを指定します。
                source = '../' + source;
                var ua = navigator.userAgent;
            　　// スマホからのアクセスか、それ以外のアクセスかを判断
                if (ua.indexOf('iPhone') > 0 || ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0) {
                    // iOS
                    document.write('<source src=' + source + ' type="application/x-mpegURL">');
                    document.write('</video>');

                }else{
                    // OTHER
                    document.write('</video>');
                    if(Hls.isSupported()) {
                        var video = document.getElementById('video');
                        var hls = new Hls();
                        hls.loadSource(source);
                        hls.attachMedia(video);
                        hls.on(Hls.Events.MANIFEST_PARSED,function() {
                            video.pause();
                        });
                    }
                }
            </script>
            <br>
            <a href="../index.php">トップへ戻る</a>
        </div>
        <footer class="vod">
            <p>© All rights reserved by ue8d.</p>
        </footer>
    </body>
</html>