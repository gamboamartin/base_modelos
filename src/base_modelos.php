<?php
namespace gamboamartin\base_modelos;

use gamboamartin\validacion\validacion;

class base_modelos extends validacion
{

    /**
     *
     * @param string $seccion
     * @param string $accion
     * @return array
     */
    public function valida_datos_lista_entrada(string $seccion, string $accion): array
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

        return array('mensaje' => $accion);
    }

    /**
     *
     * @param array $cliente
     * @return array|bool
     */
    public function valida_entrega_cliente(array $cliente): array|bool
    {

        if ($cliente['estado_entrega_entregada'] === 'activo') {
            return $this->error->error('Error la vivienda ha sido entregada', $cliente);
        }
        if ($cliente['estado_entrega_inicial'] === 'activo') {
            return $this->error->error(
                'Error la vivienda no puede ser entregada porque cliente[estado_entrega_inicial] es activo', $cliente);
        }
        return true;
    }


    public function valida_transaccion_activa(bool  $aplica_transaccion_inactivo, int $registro_id, string $tabla,
                                              array $registro): array
    {
        if (!$aplica_transaccion_inactivo) {
            if ($registro_id <= 0) {
                return $this->error->error('Error el id debe ser mayor a 0', $registro_id);
            }
            $key = $tabla . '_status';
            if (!isset($registro[$key])) {
                return $this->error->error('Error no existe el registro con el campo ' . $tabla . '_status', $registro);
            }
            if ($registro[$tabla . '_status'] === 'inactivo') {
                return $this->error->error('Error el registro no puede ser manipulado', $registro);
            }
        }

        return array('mensaje' => 'aplica transaccion');
    }


}