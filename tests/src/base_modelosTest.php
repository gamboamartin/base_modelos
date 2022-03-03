<?php
namespace tests\src;

use models\class_test;
use gamboamartin\base_modelos\base_modelos;
use gamboamartin\errores\errores;
use tests\test;


class base_modelosTest extends test {
    public errores $errores;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->errores = new errores();
    }

    public function test_valida_datos_lista_entrada(): void
    {
        errores::$error = false;
        $base_modelo = new base_modelos();
        $seccion = "";
        $accion = "";
        $resultado = $base_modelo->valida_datos_lista_entrada($seccion, $accion);

        $this->assertIsArray( $resultado);
        $this->assertStringContainsStringIgnoringCase('Error seccion no puede venir vacio', $resultado['mensaje']);
        $this->assertTrue(errores::$error);

        errores::$error = false;

        $seccion = "a";
        $accion = "";
        $resultado = $base_modelo->valida_datos_lista_entrada($seccion, $accion);
        $this->assertIsArray( $resultado);
        $this->assertStringContainsStringIgnoringCase('Error no existe la clase', $resultado['mensaje']);
        $this->assertTrue(errores::$error);
        errores::$error = false;

        $seccion = "class_test";
        $accion = "";

        $resultado = $base_modelo->valida_datos_lista_entrada($seccion, $accion);
        $this->assertIsArray( $resultado);
        $this->assertStringContainsStringIgnoringCase('Error no existe la accion', $resultado['mensaje']);
        $this->assertTrue(errores::$error);

        errores::$error = false;

        $seccion = "class_test";
        $accion = "x";

        $resultado = $base_modelo->valida_datos_lista_entrada($seccion, $accion);
        $this->assertIsBool( $resultado);
        $this->assertTrue($resultado);
        $this->assertNotTrue(errores::$error);


        errores::$error = false;
    }






}

