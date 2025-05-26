<?php

namespace Model;

class Asistencias extends ActiveRecord {

    public static $tabla = 'asistencias';
    public static $columnasDB = [
        'actividad_id',
        'asistencia_hora_llegada',
        'asistencia_situacion'
    ];

    public static $idTabla = 'asistencia_id';
    public $asistencia_id;
    public $actividad_id;
    public $asistencia_hora_llegada;
    public $asistencia_situacion;

    public function __construct($args = []){
        $this->asistencia_id = $args['asistencia_id'] ?? null;
        $this->actividad_id = $args['actividad_id'] ?? 0;
        $this->asistencia_hora_llegada = $args['asistencia_hora_llegada'] ?? '';
        $this->asistencia_situacion = $args['asistencia_situacion'] ?? 1;
    }

    public static function EliminarAsistencias($id){

        $sql = "DELETE FROM asistencias WHERE asistencia_id = $id";

        return self::SQL($sql);
    }

}