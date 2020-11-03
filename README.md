# VideoServer
## 開発環境
ubuntu server 20.04 LTS

nginx/1.18.0

php-fpm7.4

mysql/10.3.22-MariaDB-1ubuntu1

## 使い方
nginxで指定したフォルダ下にクローンする

```
git clone git@github.com:ue8d/VideoServer.git
```

プロジェクトフォルダ内に移動し、「video」フォルダと「encVideo」フォルダを作成

```
mkdir video encVideo
```

mp4形式の動画は「video」フォルダに、m3u8形式の動画は「encVideo」フォルダに入れ、ブラウザ上などで「`dbInsert.php`」を実行させると「`index.php`」で動画が認識される

## 進捗度
~~環境構築~~

~~動画を表示させる~~

~~VOD対応させる~~

[~~エンコードを自動化させる~~](https://github.com/ue8d/VideoServerEncorder)

~~DBを使ってサムネイル画像を管理する~~

リアルタイムエンコード配信可能にする