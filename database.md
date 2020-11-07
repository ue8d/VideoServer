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
CREATE TABLE users (
id int(11) AUTO_INCREMENT,
userName varchar(64) NOT NULL,
password varchar(255) NOT NULL,
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

```
INSERT INTO users (
    userName
    ,password
) VALUES (
    'ue8d'
    ,'samplepass'
);
```