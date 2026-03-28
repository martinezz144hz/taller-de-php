<?php
 
class Fibonacci {
 
    private int $numero;
 
    public function __construct(int $numero) {
        $this->numero = $numero;
    }
 
    public function calcular(): array {
        $serie = [];
 
        if ($this->numero <= 0) {
            return [0];
        }
 
        $a = 0;
        $b = 1;
        $serie[] = $a;
 
        for ($i = 1; $i <= $this->numero; $i++) {
            $serie[] = $b;
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
 
        return $serie;
    }
 
    public function getNumero(): int {
        return $this->numero;
    }
}
 
 
class Factorial {
 
    private int $numero;
 
    public function __construct(int $numero) {
        $this->numero = $numero;
    }
 
    public function calcular(): array {
        $pasos = [];
 
        if ($this->numero < 0) {
            return [];
        }
 
        $resultado = 1;
        $pasos[] = 1; // 0! = 1
 
        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado *= $i;
            $pasos[] = $resultado;
        }
 
        return $pasos;
    }
 
    public function getNumero(): int {
        return $this->numero;
    }
}
 
 
// Procesar el formulario
$numero    = null;
$operacion = null;
$resultado = [];
$error     = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero    = intval($_POST['numero'] ?? 0);
    $operacion = trim($_POST['operacion'] ?? '');
 
    if ($numero < 0) {
        $error = 'El número debe ser mayor o igual a 0.';
    } elseif ($operacion === 'fibonacci') {
        $obj       = new Fibonacci($numero);
        $resultado = $obj->calcular();
    } elseif ($operacion === 'factorial') {
        $obj       = new Factorial($numero);
        $resultado = $obj->calcular();
    } else {
        $error = 'Selecciona una operación válida.';
    }
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resultado - Fibonacci y Factorial</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #ffffff;
      color: #000000;
      padding: 40px;
    }
 
    h1 { margin-bottom: 20px; }
 
    .resultado {
      margin-top: 20px;
      font-size: 16px;
    }
 
    .serie {
      margin-top: 10px;
      font-size: 18px;
      font-weight: bold;
      word-wrap: break-word;
    }
 
    .final {
      margin-top: 14px;
      font-size: 16px;
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
 
  <?php elseif (!empty($resultado) && $operacion === 'fibonacci'): ?>
    <div class="resultado">
      <p><strong>Operación:</strong> Sucesión de Fibonacci</p>
      <p><strong>Hasta el término número:</strong> <?php echo $numero; ?></p>
      <div class="serie"><?php echo implode(' → ', $resultado); ?></div>
    </div>
 
  <?php elseif (!empty($resultado) && $operacion === 'factorial'): ?>
    <div class="resultado">
      <p><strong>Operación:</strong> Factorial</p>
      <p><strong>Número ingresado:</strong> <?php echo $numero; ?>!</p>
      <div class="serie"><?php echo implode(' → ', $resultado); ?></div>
      <div class="final">
        <strong>Resultado final:</strong> <?php echo $numero; ?>! = <?php echo end($resultado); ?>
      </div>
    </div>
 
  <?php else: ?>
    <p>No se recibieron datos. Por favor vuelve e ingresa un número.</p>
  <?php endif; ?>
 
  <a href="index.html">← Volver al ejercicio</a>
  <br/>
  <a href="../index.html">← Volver al menú principal</a>
 
</body>
</html>