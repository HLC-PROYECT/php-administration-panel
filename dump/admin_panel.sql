CREATE DATABASE IF NOT EXISTS admin_panel;

USE admin_panel;

CREATE TABLE IF NOT EXISTS `usuario` (
    `dni` varchar(9) NOT NULL,
    `email` varchar(50) NOT NULL,
    `nomb_usuario` varchar(25) DEFAULT NULL,
    `password` varchar(25) NOT NULL,
    `nombre` varchar(25) NOT NULL,
    `f_alta` date NOT NULL,
    `tipo` enum('P','A') NOT NULL,
    PRIMARY KEY (`dni`),
    UNIQUE KEY `usuario_email_uindex` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `curso` (
    `codcurso` int(11) NOT NULL AUTO_INCREMENT,
    `centroed` varchar(100) DEFAULT NULL,
    `a_inicio` year(4) DEFAULT NULL,
    `a_fin` year(4) DEFAULT NULL,
    `descrip` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`codcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=711 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `alumno` (
    `dni` varchar(9) NOT NULL,
    `fnac` date NOT NULL,
    `codcurso` int(11) NOT NULL,
    PRIMARY KEY (`dni`),
    KEY `alumno_curso_codcurso_fk` (`codcurso`),
    CONSTRAINT `alumno_curso_codcurso_fk` FOREIGN KEY (`codcurso`) REFERENCES `curso` (`codcurso`),
    CONSTRAINT `alumno_usuario_dni_fk` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `profesor` (
    `dni` varchar(9) NOT NULL,
    PRIMARY KEY (`dni`),
    CONSTRAINT `profesor_usuario_dni_fk` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `asignatura` (
    `codasig` int(11) NOT NULL AUTO_INCREMENT,
    `nombreasignatura` varchar(25) DEFAULT NULL,
    `n_horas` int(11) DEFAULT NULL,
    `anyo_fin` year(4) DEFAULT NULL,
    `codcurso` int(11) NOT NULL,
    `dniprofesor` varchar(9) NOT NULL,
    PRIMARY KEY (`codasig`),
    KEY `asignatura_curso_codcurso_fk` (`codcurso`),
    KEY `asignatura_profesor_dni_fk` (`dniprofesor`),
    CONSTRAINT `asignatura_curso_codcurso_fk` FOREIGN KEY (`codcurso`) REFERENCES `curso` (`codcurso`),
    CONSTRAINT `asignatura_profesor_dni_fk` FOREIGN KEY (`dniprofesor`) REFERENCES `profesor` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `curso_profesor` (
    `codCurso` int(11) NOT NULL DEFAULT '0',
    `dniProfesor` varchar(9) NOT NULL DEFAULT '0',
    PRIMARY KEY (`codCurso`,`dniProfesor`),
    KEY `curso_profesor_profesor_dni_fk` (`dniProfesor`),
    CONSTRAINT `curso_profesor_curso_codcurso_fk` FOREIGN KEY (`codCurso`) REFERENCES `curso` (`codcurso`),
    CONSTRAINT `curso_profesor_profesor_dni_fk` FOREIGN KEY (`dniProfesor`) REFERENCES `profesor` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tarea` (
    `codtarea` int(11) NOT NULL AUTO_INCREMENT,
    `nombretarea` varchar(25) DEFAULT NULL,
    `f_inicio` date NOT NULL,
    `f_fin` date NOT NULL,
    `estado` varchar(50) NOT NULL,
    `descrip` varchar(250) DEFAULT NULL,
    `codasig` int(11) NOT NULL,
    PRIMARY KEY (`codtarea`),
    KEY `tarea_asignatura_codasig_fk` (`codasig`),
    CONSTRAINT `tarea_asignatura_codasig_fk` FOREIGN KEY (`codasig`) REFERENCES `asignatura` (`codasig`)
) ENGINE=InnoDB AUTO_INCREMENT=1171 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tarea_alumno` (
    `dni` varchar(9) NOT NULL,
    `codtarea` int(11) NOT NULL,
    `completada` tinyint(1) DEFAULT '0',
    `clasificacion` int(11) DEFAULT '-1',
    PRIMARY KEY (`codtarea`,`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

