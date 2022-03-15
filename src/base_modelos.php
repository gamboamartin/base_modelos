<?php
namespace gamboamartin\base_modelos;

use gamboamartin\errores\errores;
use gamboamartin\validacion\validacion;

class base_modelos extends validacion
{

    /**
     * PROBADO P ORDER P INT
     * Válida los datos de una lista de entrada, debe existir la clase y no pueden venir los elementos vacios
     * También debe existe el namespace models
     * @param string $seccion
     * @param string $accion
     * @return array|bool
     */
    public function valida_datos_lista_entrada(string $accion, string $seccion): array|bool
    {
        $seccion = str_replace('models\\', '', $seccion);
        $clase_model = 'models\\' . $seccion;

        if ($seccion === '') {
            return $this->error->error('Error seccion no puede venir vacio', $seccion);
        }
        if (!class_exists($clase_model)) {
            return $this->error->error('Error no existe la clase', $seccion);
        }
        if ($accion === '') {
            return $this->error->error('Error no existe la accion', $accion);
        }

        return true;
    }

    /**
     * PROBADO
     * Funcion para validar si una vivienda puede ser o no entregada
     * @param array $cliente
     * @return array|bool
     */
    public function valida_entrega_cliente(array $cliente): array|bool
    {
        $keys = array('estado_entrega_entregada','estado_entrega_inicial');
        $valida = $this->valida_statuses($cliente,$keys);
        if(errores::$error){
            return $this->error->error('Error al validar cliente', $valida);
        }
        if ($cliente['estado_entrega_entregada'] === 'activo') {
            return $this->error->error('Error la vivienda ha sido entregada', $cliente);
        }
        if ($cliente['estado_entrega_inicial'] === 'activo') {
            return $this->error->error(
                'Error la vivienda no puede ser entregada porque cliente[estado_entrega_inicial] es activo',
                $cliente);
        }
        return true;
    }


    /**
     * P ORDER P INT
     * Válida si una operacion en un registro está inactiva en su campo status data error
     * @param bool $aplica_transaccion_inactivo
     * @param int $registro_id
     * @param string $tabla
     * @param array $registro
     * @return array|bool
     */
    public function valida_transaccion_activa(bool  $aplica_transaccion_inactivo, array $registro, int $registro_id, string $tabla): array|bool
    {
        $tabla = trim($tabla);
        if($tabla === ''){
            return $this->error->error('Error la tabla esta vacia', $tabla);
        }
        if (!$aplica_transaccion_inactivo) {
            if ($registro_id <= 0) {
                return $this->error->error('Error el id debe ser mayor a 0', $registro_id);
            }
            $key = $tabla . '_status';
            if (!isset($registro[$key])) {
                return $this->error->error('Error no existe el registro con el campo ' . $tabla . '_status',
                    $registro);
            }
            if ($registro[$tabla . '_status'] === 'inactivo') {
                return $this->error->error('Error el registro no puede ser manipulado', $registro);
            }
        }

        return true;
    }



}