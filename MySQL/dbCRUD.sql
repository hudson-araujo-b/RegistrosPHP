create database if not exists dbCRUD;

use dbCRUD;

create table if not exists Usuario(
Id int auto_increment primary key,
Nome varchar(50) not null,
Email varchar (50) not null,
Senha varchar(150) not null,
Sexo varchar(1),
DataNascimento date
);

insert into Usuario(Nome, Email, Senha, Sexo, DataNascimento) values('Teste', 'teste@gmail.com', 'teste123', 'T', '2006-01-01');

select * from Usuario;