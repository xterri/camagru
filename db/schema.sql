-- ----------------------------------------------------------------------------
-- set user permies
-- ----------------------------------------------------------------------------
GRANT CREATE ON database cama_db TO cama_user;
-- ----------------------------------------------------------------------------
-- create schema camagru
-- ----------------------------------------------------------------------------
DROP schema IF EXISTS cama_db cascade;
CREATE schema IF NOT EXISTS cama_db;
SET client_encoding to 'utf8';
-- ----------------------------------------------------------------------------
-- table camagru.test
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS cama_db.users (
  id SERIAL PRIMARY KEY NOT NULL AUTO_INCREMENT
, username VARCHAR(255) NOT NULL UNIQUE
, password VARCHAR(255) NOT NULL
, creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
, email VARCHAR(255) NOT NULL UNIQUE
, privilege VARCHAR(255) NOT NULL DEFAULT 'user'
);
-- ----------------------------------------------------------------------------
-- insert test users
-- ----------------------------------------------------------------------------
INSERT INTO cama_db.users (username, password, email) VALUES 
-- password: pwd123
  ('terri', '$2y$10$cNq1pqJy7g.759cWvpOUM.lYkh5AcSEVDzkWWedzq0iaEYora2K2q', 't@t.t')
-- password: festivus
, ('george', '$2y$10$sTeO7dfHeAkG06PtP2PEhOU1VYpN.D4m/QmVRd0XAGp1kstM8rqjS', 'g@yahoo.com')
;%
