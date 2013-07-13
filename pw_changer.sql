create table accounts (
id int unsigned not null auto_increment,
firstname varchar(255) not null,
lastname varchar(255) not null,
email varchar(255) unique not null,
newpassword varchar(255) not null,
DTstart DATETIME not null,
days int unsigned not null,
hours int unsigned not null,
DTstop DATETIME not null,
completion varchar(255),
PRIMARY KEY (id)
);

