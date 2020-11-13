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
id int(11) AUTO_INCREMENT
,userName varchar(64) NOT NULL
,password varchar(255) NOT NULL
,role int(3) default 1
,PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
```

```
CREATE TABLE alreadySeenList (
thumbId int(11) NOT NULL
,userId int(11) NOT NULL
,flag bool NOT NULL
,PRIMARY KEY (thumbId,userId)
,FOREIGN KEY fk_thumbId(thumbId) REFERENCES thumb(id)
,FOREIGN KEY fk_userId(userId) REFERENCES users(id)
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
    ,role
) VALUES (
    'ue8d'
    ,'samplepass'
    ,1
);
```

```
INSERT INTO alreadySeenList (
    thumbId
    ,userId
    ,flag
) VALUES (
    '1'
    ,'1'
    ,true
);
```