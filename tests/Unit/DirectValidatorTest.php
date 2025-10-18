<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

/**
 * Prueba Unitaria para la validación de datos de creación de productos.
 *
 * Utiliza el Facade Validator directamente para aislar las reglas de validación
 * de cualquier lógica HTTP (rutas, controladores, middleware).
 */
class DirectValidatorTest extends TestCase
{
  // Paso 1: Definir las Reglas de Validación
  protected function getProductValidationRules(): array
  {
    return [
      // Requerido, debe ser una cadena, mínimo 2 caracteres
      'name' => 'required|string|min:2|max:100',
      // Requerido, debe ser numérico, mínimo 0.01 (para evitar precios cero)
      'price' => 'required|numeric|min:0.01',
      // Requerido, debe ser entero, mínimo 0
      'stock' => 'required|integer|min:0',
      // Opcional: descripción
      'description' => 'nullable|string',
    ];
  }

  // Paso 2: Crear el Data Provider (Casos de Falla)
  /**
   * Proporciona conjuntos de datos no válidos y los campos de error esperados.
   * Estructura: [descripcion_del_caso, datos_invalidos, campos_de_error_esperados]
   */
  public static function invalidDataProvider(): array
  {
    // Datos base (utilizado para crear combinaciones de fallo)
    $baseValidData = [
      'name' => 'Laptop X',
      'price' => 100.00,
      'stock' => 10,
      'description' => 'Una descripción',
    ];

    return [
      // Caso 1: Name ausente (required fail)
      'name_missing' => [
        'name_missing',
        array_merge($baseValidData, ['name' => null]),
        ['name']
      ],
      // Caso 2: Price no es numérico
      'price_not_numeric' => [
        'price_not_numeric',
        array_merge($baseValidData, ['price' => 'abc']),
        ['price']
      ],
      // Caso 3: Stock negativo (min:0 fail)
      'stock_negative' => [
        'stock_negative',
        array_merge($baseValidData, ['stock' => -5]),
        ['stock']
      ],
      // Caso 4: Name demasiado corto (min:2 fail)
      'name_too_short' => [
        'name_too_short',
        array_merge($baseValidData, ['name' => 'a']),
        ['name']
      ],
      // Caso 5: Múltiples errores (Name corto y Price cero)
      'multiple_errors' => [
        'multiple_errors',
        array_merge($baseValidData, ['name' => 'a', 'price' => 0]),
        ['name', 'price']
      ],
    ];
  }

  // Paso 3: Crear el Método de Prueba de Falla (Uses Data Provider)
  /**
   * Prueba los casos de fallo directamente contra el validador.
   *
   * @dataProvider invalidDataProvider
   */
  public function test_validation_rules_fail_correctly(string $description, array $data, array $expectedErrors)
  {
    // Obtiene las reglas definidas en el método de ayuda
    $rules = $this->getProductValidationRules();

    // Crea una nueva instancia del Validador de Laravel
    $validator = Validator::make($data, $rules);

    // 1. Afirmar que la validación falla
    $this->assertFalse($validator->passes(), "La validación debe fallar para el caso: " . $description);

    // 2. Afirmar que el Validador tiene los errores esperados
    $errors = $validator->errors()->keys();
    // assertEqualsCanonicalizing compara arrays sin importar el orden
    $this->assertEqualsCanonicalizing($expectedErrors, $errors, 'Los campos de error no coinciden.');
  }

  // Paso 4: Crear el Método de Prueba de Éxito
  /**
   * Prueba que la validación pase con un conjunto de datos completamente válidos.
   */
  public function test_validation_passes_with_valid_data()
  {
    $validData = [
      'name' => 'Producto 123',
      'price' => 500.75,
      'stock' => 20,
      'description' => 'Esto es válido.',
    ];
    $rules = $this->getProductValidationRules();

    $validator = Validator::make($validData, $rules);

    // Afirma que la validación pasa
    $this->assertTrue($validator->passes(), 'La validación debe pasar con datos válidos.');
    $this->assertEmpty($validator->errors()->all(), 'No debe haber errores de validación.');
  }
}
