<?php
 
class Estadistica {
 
    private array $numeros;
 
    public function __construct(array $numeros) {
        $this->numeros = $numeros;
    }
 
    // Promedio: suma de todos los valores dividida entre la cantidad
    public function promedio(): float {
        $suma = array_sum($this->numeros);
        return $suma / count($this->numeros);
    }
 
    // Media: igual al promedio (media aritmética)
    public function media(): float {
        return $this->promedio();
    }
 
    // Moda: el número o números que más se repiten
    public function moda(): array {
        // Convertir a string para que array_count_values funcione con decimales
        $numerosString = array_map('strval', $this->numeros);
        $frecuencias = array_count_values($numerosString);
 
        if (empty($frecuencias)) {
            return [];
        }
 
        $maxFrecuencia = max($frecuencias);
 
        $moda = [];
        foreach ($frecuencias as $valor => $frecuencia) {
            if ($frecuencia === $maxFrecuencia) {
                $moda[] = $valor;
            }
        }
 
        return $moda;
    }
 
    public function getNumeros(): array {
        return $this->numeros;
    }
 
    public function getCantidad(): int {
        return count($this->numeros);
    }
}
 
 
// Procesar el formulario
$error     = '';
$resultado = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $input    = trim($_POST['numeros'] ?? '');
 
    // Separar los números ingresados
    $partes  = explode(',', $input);
    $numeros = [];
 
    foreach ($partes as $parte) {
        $parte = trim($parte);
        if (is_numeric($parte)) {
            $numeros[] = floatval($parte);
        }
    }
 
    if (empty($numeros)) {
        $error = 'No se ingresaron números válidos.';
    } elseif (count($numeros) !== $cantidad) {
        $error = 'La cantidad indicada (' . $cantidad . ') no coincide con los números ingresados (' . count($numeros) . ').';
    } else {
        $estadistica = new Estadistica($numeros);
        $resultado = [
            'numeros'  => $estadistica->getNumeros(),
            'cantidad' => $estadistica->getCantidad(),
            'promedio' => $estadistica->promedio(),
            'media'    => $estadistica->media(),
            'moda'     => $estadistica->moda(),
        ];
    }
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resultado - Estadística</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #ffffff;
      color: #000000;
      padding: 40px;
    }
 
    h1 { margin-bottom: 20px; }
 
    table {
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 15px;
    }
 
    table td, table th {
      border: 1px solid #999;
      padding: 8px 16px;
      text-align: left;
    }
 
    table th {
      background: #f0f0f0;
    }
 
    .error {
      color: red;
      font-size: 15px;
    }
 
    a {
      display: inline-block;
      margin-top: 20px;
      color: #0000EE;
      text-decoration: underline;
      font-size: 14px;
    }
  </style>
</head>
<body>
 
  <h1>Resultado</h1>
 
  <?php if (!empty($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
 
  <?php elseif ($resultado): ?>
    <p><strong>Números ingresados:</strong> <?php echo implode(', ', $resultado['numeros']); ?></p>
    <p><strong>Cantidad:</strong> <?php echo $resultado['cantidad']; ?></p>
 
    <table>
      <tr>
        <th>Operación</th>
        <th>Resultado</th>
      </tr>
      <tr>
        <td>Promedio</td>
        <td><?php echo round($resultado['promedio'], 4); ?></td>
      </tr>
      <tr>
        <td>Media aritmética</td>
        <td><?php echo round($resultado['media'], 4); ?></td>
      </tr>
      <tr>
        <td>Moda</td>
        <td><?php echo implode(', ', $resultado['moda']); ?></td>
      </tr>
    </table>
 
  <?php else: ?>
    <p>No se recibieron datos. Por favor vuelve e ingresa los números.</p>
  <?php endif; ?>
 
  <a href="index.html">← Volver al ejercicio</a>
  <br/>
  <a href="../index.html">← Volver al menú principal</a>
 
</body>
</html>