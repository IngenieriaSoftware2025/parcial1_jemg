<?php

namespace Model;

class Actividades extends ActiveRecord {

    public static $tabla = 'actividades';
    public static $columnasDB = [
        'actividad_nombre',
        'actividad_hora_esperada',
        'actividad_situacion'
    ];

    public static $idTabla = 'actividad_id';
    public $actividad_id;
    public $actividad_nombre;
    public $actividad_hora_esperada;
    public $actividad_situacion;

    public function __construct($args = []){
        $this->actividad_id = $args['actividad_id'] ?? null;
        $this->actividad_nombre = $args['actividad_nombre'] ?? '';
        $this->actividad_hora_esperada = $args['actividad_hora_esperada'] ?? '';
        $this->actividad_situacion = $args['actividad_situacion'] ?? 1;
    }

    public static function EliminarActividades($id){

        $sql = "DELETE FROM actividades WHERE actividad_id = $id";

        return self::SQL($sql);
    }

}