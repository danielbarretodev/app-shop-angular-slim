CREATE DATABASE IF NOT EXISTS curso_angular4;
USE curso_angular4;

CREATE TABLE productos(

  id            int(255) auto_increment not null,
  nombre        varchar(255),
  description   text,
  precio        varchar(255),
  imagen        varchar(255),
  CONSTRAINT    pk_productos PRIMARY KEY(id)
)ENGINE InnoDb;
