<?php
 
class Conjuntos {
 
    private array $a;
    private array $b;
 
    public function __construct(array $a, array $b) {
        // Eliminar duplicados dentro de cada conjunto
        $this->a = array_values(array_unique($a));
        $this->b = array_values(array_unique($b));
    }
 
    // Unión: todos los elementos de A y B sin repetir
    public function union(): array {
        $union = array_unique(array_merge($this->a, $this->b));
        sort($union);
        return array_values($union);
    }
 
    // Intersección: elementos que están en A y en B
    public function interseccion(): array {
        $interseccion = array_intersect($this->a, $this->b);
        sort($interseccion);
        return array_values($interseccion);
    }
 
    // Diferencia A - B: elementos que están en A pero no en B
    public function diferenciaAB(): array {
        $diferencia = array_diff($this->a, $this->b);
        sort($diferencia);
        return array_values($diferencia);
    }
 
    // Diferencia B - A: elementos que están en B pero no en A
    public function diferenciaBA(): array {
        $diferencia = array_diff($this->b, $this->a);
        sort($diferencia);
        return array_values($diferencia);
    }
 
    public function getA(): array { return $this->a; }
    public function getB(): array { return $this->b; }
}
 
 
// Procesar el formulario
$error     = '';
$resultado = null;
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputA = trim($_POST['conjuntoA'] ?? '');
    $inputB = trim($_POST['conjuntoB'] ?? '');
 
    // Parsear conjunto A
    $partesA = explode(',', $inputA);
    $conjuntoA = [];
    foreach ($partesA as $parte) {
        $parte = trim($parte);
        if (is_numeric($parte)) {
            $conjuntoA[] = intval($parte);
        }
    }
 
    // Parsear conjunto B
    $partesB = explode(',', $inputB);
    $conjuntoB = [];
    foreach ($partesB as $parte) {
        $parte = trim($parte);
        if (is_numeric($parte)) {
            $conjuntoB[] = intval($parte);
        }
    }
 
    if (empty($conjuntoA) || empty($conjuntoB)) {
        $error = 'Ambos conjuntos deben tener al menos un número entero válido.';
    } else {
        $conjuntos = new Conjuntos($conjuntoA, $conjuntoB);
        $resultado = [
            'a'            => $conjuntos->getA(),
            'b'            => $conjuntos->getB(),
            'union'        => $conjuntos->union(),
            'interseccion' => $conjuntos->interseccion(),
            'diferenciaAB' => $conjuntos->diferenciaAB(),
            'diferenciaBA' => $conjuntos->diferenciaBA(),
        ];
    }
}
 
// Función para mostrar un conjunto con llaves
function mostrarConjunto(array $conjunto): string {
    if (empty($conjunto)) {
        return '∅ (vacío)';
    }
    return '{ ' . implode(', ', $conjunto) . ' }';
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resultado - Conjuntos</title>
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
 
    <p><strong>Conjunto A:</strong> <?php echo mostrarConjunto($resultado['a']); ?></p>
    <p><strong>Conjunto B:</strong> <?php echo mostrarConjunto($resultado['b']); ?></p>
 
    <table>
      <tr>
        <th>Operación</th>
        <th>Resultado</th>
      </tr>
      <tr>
        <td>Unión (A ∪ B)</td>
        <td><?php echo mostrarConjunto($resultado['union']); ?></td>
      </tr>
      <tr>
        <td>Intersección (A ∩ B)</td>
        <td><?php echo mostrarConjunto($resultado['interseccion']); ?></td>
      </tr>
      <tr>
        <td>Diferencia (A - B)</td>
        <td><?php echo mostrarConjunto($resultado['diferenciaAB']); ?></td>
      </tr>
      <tr>
        <td>Diferencia (B - A)</td>
        <td><?php echo mostrarConjunto($resultado['diferenciaBA']); ?></td>
      </tr>
    </table>
 
  <?php else: ?>
    <p>No se recibieron datos. Por favor vuelve e ingresa los conjuntos.</p>
  <?php endif; ?>
 
  <a href="index.html">← Volver al ejercicio</a>
  <br/>
  <a href="../index.html">← Volver al menú principal</a>
 
</body>
</html>