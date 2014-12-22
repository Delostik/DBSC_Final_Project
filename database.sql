default character set utf8;

create table user(
	uid int primary key,
	userName char(20),
	password char(64),
	userType int
)Type=InnoDB DEFAULT CHARSET=utf8;

create table category(
	cid int primary key,
	name char(20)
)Type=InnoDB DEFAULT CHARSET=utf8;

create table book(
	bid int primary key,
	cid int,
	name char(100),
	author char(100),
	press char(100),
	ISBN char(20),
	price float,
	stock int,
	borrow int,
	pic char(50)
)Type=InnoDB DEFAULT CHARSET=utf8;

create table borrow(
	serial Bigint primary key,
	bid int,
	uid int,
	borrowtime datetime,
	returntime datetime,
	state int
)Type=InnoDB DEFAULT CHARSET=utf8;