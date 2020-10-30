# mariaDB
usr : voduser

password :

```
CREATE TABLE thumb (
id int(11) AUTO_INCREMENT,
videoName varchar(255) NOT NULL,
videoPath varchar(255) NOT NULL,
thumbPath varchar(255),
PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
```

```
INSERT INTO thumb (
    videoName
    ,videoPath
    ,thumbPath
) VALUES (
    'samplename'
    ,'samplepath'
    ,'sampelepath'
);
```