drop table if exists crudphpmvc.products;

create table if not exists crudphpmvc.products (
	id integer auto_increment primary key,
	code varchar(32) unique not null,
	name varchar(100) not null,
	price decimal,
	description varchar(256)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;