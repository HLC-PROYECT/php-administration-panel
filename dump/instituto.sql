create table curso
(
    codcurso int auto_increment
        primary key,
    centroed varchar(100) null,
    año_ini  year         null,
    año_fin  year         null,
    descrip  varchar(100) null
);

create table tarea_alumno
(
    dni           varchar(9)           not null,
    codtarea      int                  not null,
    completada    tinyint(1) default 0 not null,
    clasificacion int                  null,
    primary key (codtarea, dni)
);

create table usuario
(
    dni          varchar(9)      not null
        primary key,
    email        varchar(50)     not null,
    nomb_usuario varchar(25)     null,
    password     varchar(25)     not null,
    nombre       varchar(25)     not null,
    f_alta       date            not null,
    tipo         enum ('P', 'A') not null,
    constraint usuario_email_uindex
        unique (email)
);

create table alumno
(
    dni      varchar(9) not null
        primary key,
    fnac     date       not null,
    codcurso int        not null,
    constraint alumno_curso_codcurso_fk
        foreign key (codcurso) references curso (codcurso),
    constraint alumno_usuario_dni_fk
        foreign key (dni) references usuario (dni)
);

create table profesor
(
    dni varchar(9) not null
        primary key,
    constraint profesor_usuario_dni_fk
        foreign key (dni) references usuario (dni)
);

create table asignatura
(
    codasig          int auto_increment
        primary key,
    nombreasignatura varchar(25) null,
    n_horas          int         null,
    año_fin          year        null,
    codcurso         int         not null,
    dniprofesor      varchar(9)  not null,
    constraint asignatura_curso_codcurso_fk
        foreign key (codcurso) references curso (codcurso),
    constraint asignatura_profesor_dni_fk
        foreign key (dniprofesor) references profesor (dni)
);

create table tarea
(
    codtarea    int auto_increment
        primary key,
    nombretarea varchar(25)  null,
    f_inicio    date         not null,
    f_fin       date         not null,
    estado      varchar(50)  not null,
    descrip     varchar(250) null,
    codasig     int          not null,
    constraint tarea_asignatura_codasig_fk
        foreign key (codasig) references asignatura (codasig)
);

