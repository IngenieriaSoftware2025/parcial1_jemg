create database montes

CREATE TABLE actividades (
    actividad_id SERIAL PRIMARY KEY,
    actividad_nombre VARCHAR(100) NOT NULL,
    actividad_hora_esperada DATETIME YEAR TO SECOND NOT NULL,
    actividad_situacion SMALLINT DEFAULT 1    
);




CREATE TABLE asistencias (
    asistencia_id SERIAL PRIMARY KEY,
    actividad_id INT NOT NULL,
    asistencia_hora_llegada DATETIME YEAR TO SECOND NOT NULL,
    asistencia_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (actividad_id) REFERENCES actividades(actividad_id)
);