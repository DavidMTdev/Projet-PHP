drop table user;
drop table events;
drop table rejoin;
drop table date_survey;


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
    picture_u varchar(1000) DEFAULT '0.png' not null,
    primary key (id_user)
);

create table events (
    id_events int AUTO_INCREMENT not null,
    title varchar(30) not null,
    description_e varchar(30) not null,
    date_events datetime DEFAULT '2019-01-01 00:00:00' not null,
    -- elle change au moment de la deadline, par rapport au vote de la table date_survey
    deadline date not null,
    public int not null, 
    -- si public = 0 => event est public 
    -- si public = 1 => event est privé
    validation_events int DEFAULT 0 not null,
    -- si validation_events = 0 => event pas valider
    -- si validation_events = 1 => l'event a finis d'etre creer mais n'est pas encore valider par rapport a la deadline 
    -- si validation_events = 2 => event valider 
    id_user int not null,
    primary key (id_events),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

create table rejoin (
    id_user int not null,
    id_events int not null,
    statut int DEFAULT 0 not null,
    -- si statut = 0 => user n'a pas encore accepter ou refuser l'evenement
    -- si statut = 1 => user participe à l'evenement
    -- si statut = 2 => user ne participe pas à l'evenement
    to_vote int DEFAULT 0 not null,
    -- si to_vote = 0 alors l'user n'a pas encore voter et peut acceder aux sondage de l'evenement
    -- si to_vote = 1 l'user a voter et ne peux pu acceder aux sondages
    primary key (id_user,id_events),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_events) REFERENCES events(id_events)
);

create table date_survey (
    id_date_survey int AUTO_INCREMENT not null,
    date_events datetime not null,
    number_votes int DEFAULT 0 not null,
    id_events int not null,
    primary key (id_date_survey),
    FOREIGN KEY (id_events) REFERENCES events(id_events)
);







   








