--
-- DB creation script
-- 
CREATE TABLE FacebookObjects (
    id bigserial PRIMARY KEY,
    pageId varchar UNIQUE
);

CREATE TABLE LastfmArtists (
    id bigserial PRIMARY KEY,
    url varchar UNIQUE
);

CREATE TABLE Artists (
    id bigserial PRIMARY KEY,
    name varchar UNIQUE,
    facebookObjectId integer REFERENCES FacebookObjects (id),
    lastfmArtistId integer REFERENCES LastfmArtists (id)
);
