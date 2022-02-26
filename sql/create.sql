create database if not exists WebChat;
use WebChat;

create table if not exists Users(
    username varchar(30) not null primary key,
    password char(32) not null,
    status varchar(100) default "",
    reg_ip varchar(15) not null
);

create table if not exists Messages(
    ID int not null auto_increment primary key,
    date datetime not null,
    text varchar(1024),
    user varchar(30) not null,
    foreign key (user) references Users(username)
);

create table if not exists ChatRooms(
    ID int not null auto_increment primary key,
    name varchar(50) not null unique
);

create table if not exists ChatroomUsers(
    user varchar(30) not null,
    ChatRoom int not null,
    primary key (user, ChatRoom)
);

create table Accesses (
    ID int not null auto_increment primary key,
    user varchar(30) not null,
    date datetime not null,
    foreign key (user) references Users(username)
);