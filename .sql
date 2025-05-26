create database montes

CREATE TABLE actividades (
    actividad_id SERIAL PRIMARY KEY,
    actividad_nombre VARCHAR(100) NOT NULL,
    actividad_hora_esperada DATETIME YEAR TO SECOND NOT NULL,
    actividad_situacion SMALLINT DEFAULT 1    
);



