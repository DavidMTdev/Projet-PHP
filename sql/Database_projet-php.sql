drop table user;
drop table events;
drop table rejoin;


ALTER DATABASE sportify CHARACTER SET utf8 COLLATE utf8_general_ci;



create table user (
    id_user int AUTO_INCREMENT not null,
    name_u varchar(30) not null,
    first_name_u varchar(30) not null,
    password_u varchar(100) not null,
    age_u int(2) not null,
    description_u varchar(250) null,
    adress_u varchar(100) null,
    city_u varchar(100) null,
    postal_code_u varchar(5) null,
    mail_u varchar(100) UNIQUE not null,
    phone_u varchar(100) not null,
    picture_u varchar(1000) DEFAULT '0.png',
    primary key (id_user)
);

create table events (
    id_events int AUTO_INCREMENT not null,
    title varchar(30) not null,
    description_e varchar(30) not null,
    deadline date not null,
    public int not null,
    id_user int not null,
    primary key (id_events),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

create table rejoin (
    id_user int not null,
    id_events int not null,
    statut int not null,
    primary key (id_user,id_events),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_events) REFERENCES events(id_events)
);





   








