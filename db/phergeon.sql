------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS session CASCADE;

CREATE TABLE session
(
    id CHAR(40) NOT NULL PRIMARY KEY,
    expire INTEGER,
    data BYTEA,
    user_id BIGINT
);


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
   ,posx double precision
   ,posy double precision
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
   ,raza bigint NOT NULL REFERENCES razas (id) ON DELETE NO ACTION ON UPDATE CASCADE DEFAULT 1
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
   ,aprobado bool NOT NULL DEFAULT FALSE
   ,fecha_adopcion timestamp(0) NOT NULL DEFAULT localtimestamp
   ,unique (id_usuario_donante, id_usuario_adoptante, id_animal)
);

INSERT INTO roles (denominacion)
    VALUES ('usuario')
         , ('asociacion');

INSERT INTO usuarios (nombre_usuario, nombre_real, email, posx, posy,  password, created_at, rol)
    VALUES ('danigove', 'Daniel Gómez Vela', 'dani5002@hotmail.com', -3.2313 , 2.91823 ,crypt('danigove', gen_salt('bf', 13)), current_timestamp(0),1)
          ,('briganimalista', 'Brigada Animalista Sanlúcar', 'brigada@gmail.com', 5.231 , -7.91 , crypt('brigada', gen_salt('bf', 13)), current_timestamp(0),2);


INSERT INTO tipos (denominacion_tipo)
    VALUES ('Perro'),
           ('Gato'),
           ('Exótico');

INSERT INTO razas (tipo_animal, denominacion_raza)
    VALUES  ('1', 'Mestizo'),
            ('1', 'Labrador'),
            ('1', 'Mastín'),
            ('2', 'Mainecoon'),
            ('2', 'Siamés'),
            ('3', 'Otros'),
            ('3', 'Hurón');

INSERT INTO animales (id_usuario, nombre, tipo_animal, raza, descripcion, edad, sexo)
    VALUES (1, 'Toby', '1', '2', 'Precioso labrador de 2 años', 2, 'Macho'),
           (1, 'Batman', '2', '2', 'Precioso siames de 4 años', 1, 'Macho'),
           (2, 'Rafaela', '1', '3', 'Precioso mastín de 2 años', 2, 'Macho'),
           (2, 'Chawarma', '1', '1', 'Precioso perrete de 2 años', 2, 'Macho'),
           (2, 'Ronaldinho', '1', '3', 'Precioso perrete de 6 años', 6, 'Macho'),
           (2, 'Carla', '2', '2', 'Precioso gatete de 2 años', 2, 'Hembra'),
           (2, 'Trinity', '3', '2', 'Precioso hurón de 2 años', 2, 'Hembra');
