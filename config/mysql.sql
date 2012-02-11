create table if not exists dictionaries (
	id integer not null primary key auto_increment,
	name varchar(255) not null,
	licenser varchar(255),
	created_at timestamp not null,
	updated_at timestamp not null,
	dictionary_records_count integer not null default '0',
	create_user varchar(12) not null,
	update_user varchar(12) not null,
	delete_flag tinyint default '0' not null,
	user_read tinyint default '1' not null,
	user_write tinyint default '1' not null,
	any_read tinyint default '1' not null,
	any_write tinyint default '1' not null
) ENGINE=InnoDB;

create table if not exists dictionary_records (
	id integer not null primary key auto_increment,
	dictionary_id integer not null
) ENGINE=InnoDB;

create table if not exists dictionary_contents (
	id integer not null primary key auto_increment,
	dictionary_record_id integer not null,
	language varchar(2),
	contents text,
	create_at timestamp,
	update_at timestamp,
	create_user varchar(12),
	update_user varchar(12),
	unique(dictionary_record_id, language)
) ENGINE=InnoDB;

create table if not exists dictionaries_languages (
	id integer not null primary key auto_increment,
	dictionary_id integer,
	language varchar(2)
) ENGINE=InnoDB;

create table if not exists dictionaries_deployments (
	id integer not null primary key auto_increment,
	dictionary_id integer not null,
	create_at timestamp,
	create_user varchar(12)
) ENGINE=InnoDB;

create table if not exists dictionaries_tags (
	dictionary_id integer not null,
	tag_id integer not null
) ENGINE=InnoDB;

create table if not exists tags (
	id integer not null primary key auto_increment,
	value varchar(24) not null unique
) ENGINE=InnoDB;