--
-- DB creation script
-- 
CREATE TABLE LastfmArtists (
    id serial PRIMARY KEY,
    url varchar(1000) UNIQUE,
    image varchar(1000)
);

CREATE TABLE FacebookObjects (
    id serial PRIMARY KEY,
    pageId varchar(100) UNIQUE,
    category VARCHAR(200)
);

CREATE TABLE Artists (
    id serial PRIMARY KEY,
    name varchar (200) UNIQUE,
    lastfmArtistId int REFERENCES LastfmArtists(id),
    facebookObjectId int REFERENCES FacebookObjects(id)
);


CREATE TABLE Albums (
    id serial PRIMARY KEY,
    name varchar (200) NOT NULL,
    date date NOT NULL,
    artistId int REFERENCES Artists(id),
    url varchar(1000) UNIQUE
);

CREATE TABLE Tags (
    id serial PRIMARY KEY,
    name varchar (100) UNIQUE,
    url varchar(1000) UNIQUE
);

CREATE TABLE ArtistTags (
    tagId int REFERENCES Tags(id),
    artistId int REFERENCES Artists(id),
    PRIMARY KEY (tagId, artistId)
);

CREATE TABLE Fans (
    id serial PRIMARY KEY,
    age int default 0,
    url varchar(1000) UNIQUE
);


CREATE TABLE ArtistFans (
    fanId int REFERENCES Fans(id),
    artistId int REFERENCES Artists(id),
    PRIMARY KEY (fanId, artistId)
);


CREATE TABLE SimilarArtists (
    artistId1 int REFERENCES Artists(id),
    artistId2 int REFERENCES Artists(id),
    PRIMARY KEY (artistId1, artistId2)
);

CREATE TABLE Users (
    id serial PRIMARY KEY,
    userid varchar(200) UNIQUE
);

CREATE TABLE Likes (
    userId int REFERENCES Users(id),
    facebookObjectId int REFERENCES FacebookObjects(id),
    valid BOOLEAN NOT NULL DEFAULT FALSE,
    timestamp TIMESTAMP NOT NULL DEFAULT NOW(),
    PRIMARY KEY (userId, facebookObjectId)
);

CREATE TABLE Friends (
    userId1 int REFERENCES Users(id),
    userId2 int REFERENCES Users(id),
    PRIMARY KEY (userId1, userId2)
);

-- Ignore duplicates when inserting friends in batch mode
CREATE OR REPLACE RULE friends_ignore_duplicate_inserts AS
    ON INSERT TO friends
        WHERE (
            EXISTS (
                SELECT 1 
                    FROM friends 
                    WHERE friends.userid1 = NEW.userid1 AND friends.userid2 = NEW.userid2
            )
        ) DO INSTEAD NOTHING;

-- Ignore duplicates when inserting tags in batch mode
CREATE OR REPLACE RULE tags_ignore_duplicate_inserts AS
    ON INSERT TO tags
        WHERE (
            EXISTS (
                SELECT 1 
                    FROM tags 
                    WHERE tags.id = NEW.id
            )
        ) DO INSTEAD NOTHING;