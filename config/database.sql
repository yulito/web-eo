CREATE TABLE ROL(
    id_rol int primary key not null,
    rol char(12) not null unique   
)ENGINE=INNODB;

CREATE TABLE STATE(
    id_state int primary key not null,
    state char(12) not null unique
)ENGINE=INNODB;

CREATE TABLE CATEGORY(
    id_cat int primary key not null,
    cat varchar(100) not null unique
)ENGINE=INNODB;

CREATE TABLE USERS(
    id_user bigint unsigned auto_increment primary key not null,
    name varchar(70) not null unique, 
    birth_date date not null, -- (YYYY-MM-DD)
    photo varchar(255) default null,
    email varchar(255) not null unique,
    password varchar(255) not null,
    token varchar(255) default null,
    created_at timestamp default NOW(),
    updated_at timestamp default NOW(),
    id_rol int not null
)ENGINE=INNODB;
ALTER TABLE users ADD CONSTRAINT user_rol_fk FOREIGN KEY (id_rol) REFERENCES rol (id_rol);

CREATE TABLE PUBLICATION(
    id_publication bigint unsigned auto_increment primary key not null,
    title char(100) not null,
    publication TEXT, -- "65.535", alt = MEDIUMTEXT, LONGTEXT
    id_state int default (1) not null,
    id_user bigint unsigned not null,
    id_cat int not null,
    created_at timestamp default NOW(),
    updated_at timestamp default NOW()
)ENGINE=INNODB;
ALTER TABLE publication ADD CONSTRAINT pub_state_fk 
			FOREIGN KEY (id_state) REFERENCES state (id_state);
ALTER TABLE publication ADD CONSTRAINT pub_user_fk 
			FOREIGN KEY (id_user) REFERENCES users (id_user);
ALTER TABLE publication ADD CONSTRAINT pub_cat_fk 
			FOREIGN KEY (id_cat) REFERENCES category (id_cat);

CREATE TABLE LIKES(
    id_like bigint unsigned auto_increment primary key not null,
    id_user bigint unsigned not null,
    id_publication bigint unsigned not null
)ENGINE=INNODB;
ALTER TABLE likes ADD CONSTRAINT like_user_fk 
			FOREIGN KEY (id_user) REFERENCES users (id_user);
ALTER TABLE likes ADD CONSTRAINT like_pub_fk 
			FOREIGN KEY (id_publication) REFERENCES publication (id_publication);

CREATE TABLE FAVOURITE(
    id_fav bigint unsigned auto_increment primary key not null,
    id_user bigint unsigned not null,
    id_publication bigint unsigned not null
)ENGINE=INNODB;
ALTER TABLE favourite ADD CONSTRAINT fav_user_fk 
			FOREIGN KEY (id_user) REFERENCES users (id_user);
ALTER TABLE favourite ADD CONSTRAINT fav_pub_fk 
			FOREIGN KEY (id_publication) REFERENCES publication (id_publication);

-- INSERTS
insert into rol values(1, 'superadmin'),(2,'subadmin'),(3,'admin'),(4,'user');
insert into state values(1,'En espera'),(2,'Publicado'),(3,'Descartado');
insert into category values(1, 'borrachos'),(2, 'religiosos/curas/monjas'),
							(3, 'amigos/amistad'),(4, 'animalitos'),
                            (5, 'chistes blancos/inocentes'),(6, 'oficios/profesiones'),
                            (7,'anecdotas/historias'),(8,'politicos'),
                            (9, 'chiste de comparaciones'),(10, 'chistes cortos'),
                            (11, 'sin censura'), (12,'bizarros');       
            
COMMIT;
