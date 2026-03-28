<?php
 
class Binario {
 
    private int $numero;
 
    public function __construct(int $numero) {
        $this->numero = $numero;
    }
 
    // Convierte el número a binario y devuelve el resultado como string
    public function convertir(): string {
        if ($this->numero === 0) {
            return '0';
        }
 
        $numero   = abs($this->numero);
        $binario  = '';
 
        while ($numero > 0) {
            $binario = ($numero % 2) . $binario;
            $numero  = intdiv($numero, 2);
        }
 
        // Si el número original era negativo, agregar signo
        if ($this->numero < 0) {
            $binario = '-' . $binario;
        }
 
        return $binario;
    }
 
    // Devuelve los pasos del proceso de conversión
    public function getPasos(): array {
        if ($this->numero === 0) {
            return [['numero' => 0, 'division' => 0, 'residuo' => 0]];
        }
 
        $numero = abs($this->numero);
        $pasos  = [];
 
        while ($numero > 0) {
            $pasos[] = [
                'numero'   => $numero,
                'division' => intdiv($numero, 2),
                'residuo'  => $numero % 2,
            ];
            $numero = intdiv($numero, 2);
        }
 
        return $pasos;
    }
 
    public function getNumero(): int {
        return $this->numero;
    }
}
 
 
// Procesar el formulario
$error     = '';
$resultado = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['numero'] ?? '');
 
    if (!is_numeric($input)) {
        $error = 'Por favor ingresa un número entero válido.';
    } else {
        $numero   = intval($input);
        $binario  = new Binario($numero);
        $resultado = [
            'numero'  => $binario->getNumero(),
            'binario' => $binario->convertir(),
            'pasos'   => $binario->getPasos(),
        ];
    }
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resultado - Conversor a Binario</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #ffffff;
      color: #000000;
      padding: 40px;
    }
 
    h1 { margin-bottom: 20px; }
 
    .binario {
      font-size: 32px;
      font-weight: bold;
      margin: 16px 0;
    }
 
    table {
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 15px;
    }
 
    table td, table th {
      border: 1px solid #999;
      padding: 8px 16px;
      text-align: center;
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
 
    <p><strong>Número ingresado:</strong> <?php echo $resultado['numero']; ?></p>
    <p><strong>Resultado en binario:</strong></p>
    <div class="binario"><?php echo $resultado['binario']; ?></div>
 
    <br/>
    <p><strong>Proceso de conversión (divisiones sucesivas entre 2):</strong></p>
    <table>
      <tr>
        <th>Número</th>
        <th>División entre 2</th>
        <th>Residuo (bit)</th>
      </tr>
      <?php foreach ($resultado['pasos'] as $paso): ?>
      <tr>
        <td><?php echo $paso['numero']; ?></td>
        <td><?php echo $paso['division']; ?></td>
        <td><?php echo $paso['residuo']; ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <p><em>El binario se lee de abajo hacia arriba en la columna de residuos.</em></p>
 
  <?php else: ?>
    <p>No se recibieron datos. Por favor vuelve e ingresa un número.</p>
  <?php endif; ?>
 
  <a href="index.html">← Volver al ejercicio</a>
  <br/>
  <a href="../index.html">← Volver al menú principal</a>
 
</body>
</html>