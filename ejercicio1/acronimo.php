<?php
 
class Acronimo {
 
    private string $frase;
 
    public function __construct(string $frase) {
        $this->frase = $frase;
    }
 
    public function convertir(): string {
        // Reemplazar guiones por espacios
        $frase = str_replace('-', ' ', $this->frase);
 
        // Eliminar todos los signos de puntuación excepto espacios y letras
        $frase = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/', '', $frase);
 
        // Separar en palabras
        $palabras = explode(' ', $frase);
 
        $acronimo = '';
 
        foreach ($palabras as $palabra) {
            $palabra = trim($palabra);
            if (!empty($palabra)) {
                // Tomar la primera letra de cada palabra en mayúscula
                $acronimo .= strtoupper($palabra[0]);
            }
        }
 
        return $acronimo;
    }
 
    public function getFrase(): string {
        return $this->frase;
    }
}
 
// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $frase = trim($_POST['frase'] ?? '');
 
    if (!empty($frase)) {
        $acronimo = new Acronimo($frase);
        $resultado = $acronimo->convertir();
    }
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Resultado - Acrónimo</title>
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
 
    .acronimo {
      font-size: 32px;
      font-weight: bold;
      margin-top: 10px;
    }
 
    a {
      display: inline-block;
      margin-top: 30px;
      color: #0000EE;
      text-decoration: underline;
      font-size: 14px;
    }
  </style>
</head>
<body>
 
  <h1>Resultado</h1>
 
  <?php if (!empty($frase) && isset($resultado)): ?>
    <div class="resultado">
      <p><strong>Frase ingresada:</strong> <?php echo htmlspecialchars($frase); ?></p>
      <p><strong>Acrónimo:</strong></p>
      <div class="acronimo"><?php echo htmlspecialchars($resultado); ?></div>
    </div>
  <?php else: ?>
    <p>No se recibió ninguna frase. Por favor vuelve e ingresa una frase.</p>
  <?php endif; ?>
 
  <a href="index.html">← Volver al ejercicio</a>
  <br/>
  <a href="../index.html">← Volver al menú principal</a>
 
</body>
</html>