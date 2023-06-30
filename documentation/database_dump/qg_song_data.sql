create table Artist
(
    id       int auto_increment
        primary key,
    name_cyr varchar(150)                       null,
    name_lat varchar(150)                       null,
    created  datetime default CURRENT_TIMESTAMP not null,
    modified datetime default CURRENT_TIMESTAMP not null
);

ALTER TABLE Artist AUTO_INCREMENT=20000000;


create table Album
(
    id             int auto_increment
        primary key,
    name_cyr       varchar(150)                       null,
    name_lat       varchar(150)                       null,
    cover_art      varchar(1000)                      null,
    release_date   datetime default CURRENT_TIMESTAMP null,
    created        datetime default CURRENT_TIMESTAMP not null,
    modified       datetime default CURRENT_TIMESTAMP not null,
    main_artist_id int                                null,
    constraint Album_Artist_id_fk
        foreign key (main_artist_id) references Artist (id)
            on update cascade
);

ALTER TABLE Album AUTO_INCREMENT=10000000;

create table AlbumArtists
(
    id        int auto_increment
        primary key,
    album_id  int not null,
    artist_id int not null,
    constraint AlbumArtists_Album_id_fk
        foreign key (album_id) references Album (id)
            on update cascade on delete cascade,
    constraint AlbumArtists_Artist_id_fk
        foreign key (artist_id) references Artist (id)
            on update cascade on delete cascade
);

create table Song
(
    id             int auto_increment
        primary key,
    title_cyr      varchar(300)                       null,
    title_lat      varchar(300)                       null,
    release_date   datetime default CURRENT_TIMESTAMP null,
    cover_art      varchar(1000)                      null,
    created        datetime default CURRENT_TIMESTAMP null,
    modified       datetime default CURRENT_TIMESTAMP null,
    main_artist_id int                                null,
    album_id       int                                null,
    published      bool default false                 null,
    constraint Song_Album_id_fk
        foreign key (album_id) references Album (id)
            on update cascade on delete set null,
    constraint Song_Artist_id_fk
        foreign key (main_artist_id) references Artist (id)
            on update cascade on delete set null
);

ALTER TABLE Song AUTO_INCREMENT=50000000;

create table Lyrics
(
    id            int auto_increment
        primary key,
    verse_nr      int                                                   not null,
    line_nr       int                                                   not null,
    qazaq_cyr     varchar(1000)                                         null,
    qazaq_lat     varchar(1000)                                         null,
    english       varchar(1000)                                         null,
    russian       varchar(1000)                                         null,
    original_lang enum ('qazaq_cyr', 'qazaq_lat', 'english', 'russian') not null comment 'Language which is translated into to remaining languages.
This enum has to be updated everytime a new language gets added!',
    created       datetime default CURRENT_TIMESTAMP                    not null,
    modfied       datetime default CURRENT_TIMESTAMP                    not null,
    song_id       int                                                   not null,
    constraint Lyrics_Song_id_fk
        foreign key (song_id) references Song (id)
            on update cascade on delete cascade
);

ALTER TABLE Lyrics AUTO_INCREMENT=30000000;

create table Media
(
    id       int auto_increment
        primary key,
    name     varchar(150)                       not null,
    url      varchar(1000)                      not null,
    created  datetime default CURRENT_TIMESTAMP not null,
    modified datetime default CURRENT_TIMESTAMP null,
    song_id  int                                not null,
    constraint Media_Song_id_fk
        foreign key (song_id) references Song (id)
            on update cascade on delete cascade
);

ALTER TABLE Media AUTO_INCREMENT=40000000;

create table SongArtists
(
    id        int auto_increment
        primary key,
    artist_id int not null,
    song_id   int not null,
    constraint SongArtists_Artist_id_fk
        foreign key (artist_id) references Artist (id)
            on update cascade on delete cascade,
    constraint SongArtists_Song_id_fk
        foreign key (song_id) references Song (id)
            on update cascade on delete cascade
)
    comment 'Additional artists for a song (feat.)';

create table Words
(
    id              int auto_increment
        primary key,
    word_in_line_nr tinyint                            not null,
    qazaq_cyr       varchar(150)                       null,
    qazaq_lat       varchar(150)                       null,
    english         varchar(150)                       null,
    russian         varchar(150)                       null,
    additional_info text                               null,
    created         datetime default CURRENT_TIMESTAMP not null,
    modified        datetime default CURRENT_TIMESTAMP not null,
    lyrics_id       int                                null,
    constraint Words_Lyrics_id_fk
        foreign key (lyrics_id) references Lyrics (id)
            on update cascade on delete set null
);

ALTER TABLE Words AUTO_INCREMENT=60000000;