------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
    id bigserial PRIMARY KEY
   ,denominacion varchar(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(

    id bigserial PRIMARY KEY
   ,nombre_usuario varchar(255) NOT NULL UNIQUE
   ,nombre_real varchar(255) NOT NULL
   ,email varchar(255) NOT NULL
   ,password varchar(255) NOT NULL
   ,created_at timestamp(0)
   ,sesskey varchar(255)
   ,token_val varchar(255) UNIQUE
   ,rol bigint NOT NULL REFERENCES roles (id) ON DELETE NO ACTION ON UPDATE CASCADE DEFAULT 1

);

CREATE INDEX idx_usuarios_email ON usuarios (email);
CREATE INDEX idx_usuarios_nombre_real ON usuarios (nombre_real);

DROP TABLE IF EXISTS tipos CASCADE;

CREATE TABLE tipos
(
    id bigserial PRIMARY KEY
   ,denominacion_tipo varchar(255) NOT NULL UNIQUE

);

DROP TABLE IF EXISTS razas CASCADE;

CREATE TABLE razas
(
    id bigserial PRIMARY KEY
   ,tipo_animal bigint NOT NULL REFERENCES tipos (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,denominacion_raza varchar(255) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS animales CASCADE;

CREATE TABLE animales
(
    id bigserial PRIMARY KEY
   ,id_usuario bigint NOT NULL REFERENCES usuarios (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,nombre varchar(255) NOT NULL
   ,tipo_animal bigint NOT NULL REFERENCES tipos (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,raza bigint NOT NULL REFERENCES razas (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,descripcion varchar(255) NOT NULL
   ,edad varchar(255) NOT NULL
   ,sexo varchar(255) NOT NULL
);

CREATE INDEX idx_animales_sexo ON animales (sexo);
CREATE INDEX idx_animales_sexo ON animales (edad);

DROP TABLE IF EXISTS facturas CASCADE;

CREATE TABLE facturas
(
    id bigserial PRIMARY KEY
   ,id_animal bigint NOT NULL REFERENCES animales (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,fecha_emision timestamp(0) NOT NULL DEFAULT localtimestamp
   ,centro_veterinario varchar(255) NOT NULL
   ,descripcion varchar(255) NOT NULL
   ,importe numeric(5,2) NOT NULL
);

DROP TABLE IF EXISTS historiales CASCADE;

CREATE TABLE historiales
(
    id bigserial PRIMARY KEY
   ,id_animal bigint NOT NULL REFERENCES animales (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,descripcion varchar(255) NOT NULL
);

DROP TABLE IF EXISTS adopciones CASCADE;

CREATE TABLE adopciones
(
    id bigserial PRIMARY KEY
   ,id_usuario_donante bigint NOT NULL REFERENCES usuarios (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,id_usuario_adoptante bigint NOT NULL REFERENCES usuarios (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,id_animal bigint NOT NULL REFERENCES animales (id) ON DELETE NO ACTION ON UPDATE CASCADE
   ,fecha_adopcion timestamp(0) NOT NULL DEFAULT localtimestamp
);

INSERT INTO roles (denominacion)
    VALUES ('usuario')
         , ('asociacion');

INSERT INTO usuarios (nombre_usuario, nombre_real, email, password, created_at, rol)
    VALUES ('danigove', 'Daniel Gómez Vela', 'dani5002@hotmail.com', crypt('danigove', gen_salt('bf', 13)), current_timestamp(0),1)
          ,('briganimalista', 'Brigada Animalista Sanlúcar', 'brigada@gmail.com',crypt('brigada', gen_salt('bf', 13)), current_timestamp(0),2);
