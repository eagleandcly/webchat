-- user 用户表
-- 用户ID 用户名 用户密码 用户头像 用户性别 用户签名 是否登录 创建时间

-- 关系表
-- 关系ID 用户ID 朋友ID 组ID 是否删除 创建时间 

-- 消息表
-- 消息ID 用户ID 发送对象ID 发送内容 发送时间

create database chat charset utf8;
use chat 
create table user(
user_id int primary key auto_increment,
username char(30) not null default '',
password char(30) not null default '',
sex char(4) not null default '',
hpot varchar(100) not null default '',
sign varchar(300) not null default '',
is_login char(4) not null default '',
time int not null default 0
)engine myisam charset utf8;

create table relate(
rela_id int primary key auto_increment,
user_id int not null default 0,
ruser_id int not null default 0,
is_delete char(4) not null default '',
time int not null default 0 
)engine myisam charset utf8;

create table msg(
msg_id int primary key auto_increment,
user_id int not null default 0,
ruser_id int not null default 0,
content varchar(500) not null default '',
time int not null default 0
)engine myisam charset utf8; 