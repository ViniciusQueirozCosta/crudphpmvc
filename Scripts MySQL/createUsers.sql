drop table if exists crudphpmvc.users;

create table if not exists crudphpmvc.users (
	id integer auto_increment primary key,
	username varchar(32) unique not null,
	password varchar(100) not null,
	fullname varchar(100),
	email varchar(100) unique
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;