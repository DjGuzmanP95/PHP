<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios PHP</title>
    <?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    ?>
</head>

<body>
    <div>
        <?php
        if (
            $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["conversor"]) && $_POST["conversor"] == "ej08"
        ) {


            $divisas = [
                "EUR" => [
                    "nombre" => "Euro",
                    "tasa" => 1
                ],
                "USD" => [
                    "nombre" => "Dólar estadounidense",
                    "tasa" => 1.12
                ],
                "GBP" => [
                    "nombre" => "Libra esterlina",
                    "tasa" => 0.85
                ],
                "JPY" => [
                    "nombre" => "Yen japonés",
                    "tasa" => 160
                ]
            ];

            // 2. Recibir los datos del formulario
        
            $cantidad = (float) ($_POST["cantidad"] ?? 0);
            $origen = $_POST["origen"] ?? "";
            $destino = $_POST["destino"] ?? "";

            // 3. Validar los datos recibidos
        
            if (
                $cantidad <= 0 ||
                !isset($divisas[$origen]) ||
                !isset($divisas[$destino])
            ) {
                echo "<h2>Error en los datos introducidos</h2>";
                echo "<p>Comprueba la cantidad y las divisas seleccionadas.</p>";
            } else {
                // 4. Obtener las tasas de cambio        
                $tasaOrigen = $divisas[$origen]["tasa"];
                $tasaDestino = $divisas[$destino]["tasa"];

                // 5. Realizar la conversión        
                $cantidadEuros = $cantidad / $tasaOrigen;
                $resultado = $cantidadEuros * $tasaDestino;

                // 6. Mostrar el resultado        
                echo "<h2>Resultado de la conversión</h2>";
                echo "<table border='1'>";
                echo "<tr>";
                echo "<th>Concepto</th>";
                echo "<th>Resultado</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Cantidad original</td>";
                echo "<td>" . number_format($cantidad, 2, ",", ".") . " " . $origen . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Divisa de origen</td>";
                echo "<td>" . $divisas[$origen]["nombre"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Divisa de destino</td>";
                echo "<td>" . $divisas[$destino]["nombre"] . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Tipo de cambio aplicado</td>";
                echo "<td>" . $tasaOrigen . " / " . $tasaDestino . "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><strong>Resultado final</strong></td>";
                echo "<td><strong>" . number_format($resultado, 2, ",", ".") . " " . $destino . "</strong></td>";
                echo "</tr>";
                echo "</table>";
            }
            echo '<p><a href="Ejercicios_php.html">Volver a los ejercicios</a></p>';
        } else {
            echo "<h2>Acceso no válido</h2>";
            echo "<p>Debes acceder desde el formulario.</p>";
        }
        ?>
    </div>

    <div>
        <?php

        if (
            $_SERVER["REQUEST_METHOD"] == "POST" &&
            isset($_POST["imc"]) &&
            $_POST["imc"] == "ej09"
        ) {

            // 1. Array asociativo multidimensional con las clasificaciones
        
            $clasificaciones = [
                ["limite" => 18.5, "categoria" => "Bajo peso"],
                ["limite" => 25.0, "categoria" => "Peso normal"],
                ["limite" => 30.0, "categoria" => "Sobrepeso"],
                ["limite" => INF, "categoria" => "Obesidad"]
            ];

            // 2. Recibir los datos del formulario
        
            $peso = (float) ($_POST["peso"] ?? 0);
            $altura = (float) ($_POST["altura"] ?? 0);

            // 3. Validar los datos recibidos
        
            if (
                $peso <= 0 ||
                $altura <= 0
            ) {
                echo "<h2>Error en los datos introducidos</h2>";
                echo "<p>El peso y la altura deben ser valores positivos.</p>";
            } else {
                // 4. Calcular el IMC        
                $imcCalculado = $peso / ($altura ** 2);
                // 5. Clasificar el resultado recorriendo el array        
                $clasificacion = "";
                foreach ($clasificaciones as $rango) {
                    if ($imcCalculado < $rango["limite"]) {
                        $clasificacion = $rango["categoria"];
                        break;
                    }
                }

                // 6. Mostrar los resultados
                ?>

                <?php
                function tabla($peso, $altura, $imcCalculado, $clasificacion)
                {
                    ?>

                    <h2>Resultado del cálculo del IMC</h2>

                    <table border="1">
                        <tr>
                            <th>Dato</th>
                            <th>Resultado</th>
                        </tr>
                        <tr>
                            <td>Peso</td>
                            <td><?= number_format($peso, 2, ",", ".") ?> kg</td>
                        </tr>
                        <tr>
                            <td>Altura</td>
                            <td><?= number_format($altura, 2, ",", ".") ?> m</td>
                        </tr>
                        <tr>
                            <td>IMC</td>
                            <td><?= number_format($imcCalculado, 2, ",", ".") ?></td>
                        </tr>
                        <tr>
                            <td>Clasificación</td>
                            <td><?= htmlspecialchars($clasificacion) ?></td>
                        </tr>
                    </table>

                    <?php
                }
                ?>
                <?php
                tabla($peso, $altura, $imcCalculado, $clasificacion);

            }

            echo '<p><a href="imc.html">Volver a la calculadora</a></p>';

        } else {

            echo "<h2>Acceso no válido</h2>";
            echo "<p>Debes acceder desde el formulario.</p>";

        }

        ?>
    </div>
    <div>
        <?php

        if (
            $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cesta"]) && $_POST["cesta"] == "ej11"
        ) {
            $productos = [
                "manzanas" => ["nombre" => "Manzanas", "precio" => 1.50, "categoria" => "Alimentación", "iva" => 4],
                "leche" => ["nombre" => "Leche", "precio" => 0.90, "categoria" => "Alimentación", "iva" => 4],
                "pan" => ["nombre" => "Pan", "precio" => 1.20, "categoria" => "Alimentación", "iva" => 4],
                "cerveza" => ["nombre" => "Cerveza", "precio" => 2.50, "categoria" => "Bebidas", "iva" => 10],
                "refresco" => ["nombre" => "Refresco", "precio" => 1.80, "categoria" => "Bebidas", "iva" => 10],
                "raton" => ["nombre" => "Ratón inalámbrico", "precio" => 25.00, "categoria" => "Electrónica", "iva" => 21]
            ];
            $seleccionados = [];

            foreach ($productos as $campo => $producto) {

                $cantidad = (int) ($_POST[$campo] ?? 0);

                if ($cantidad > 0) {
                    $producto["cantidad"] = $cantidad;
                    $seleccionados[] = $producto;
                }
            }
            $totalSinDescuento = 0;
            $totalDescuentos = 0;
            $totalIva = 0;
            if (empty($seleccionados)) {
                echo "<h2>Tu cesta está vacía</h2>";
            } else {
                echo "<h2>Ticket de compra</h2>";
                echo "<table border='1'>";
                echo "<tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Precio unidad</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>IVA</th>
                <th>Total</th>
              </tr>";
                foreach ($seleccionados as $producto) {
                    $subtotal = $producto["cantidad"] * $producto["precio"];
                    if ($producto["cantidad"] >= 10) {
                        $porcentajeDescuento = 20;
                    } elseif ($producto["cantidad"] >= 5) {
                        $porcentajeDescuento = 10;
                    } else {
                        $porcentajeDescuento = 0;
                    }
                    $descuento = $subtotal * $porcentajeDescuento / 100;

                    // Calcular base imponible e IVA
                    $baseProducto = $subtotal - $descuento;
                    $iva = $baseProducto * $producto["iva"] / 100;
                    // Total por producto
                    $totalProducto = $baseProducto + $iva;
                    // Acumular totales
                    $totalSinDescuento += $subtotal;
                    $totalDescuentos += $descuento;
                    $totalIva += $iva;
                    // Mostrar fila
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($producto["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($producto["categoria"]) . "</td>";
                    echo "<td>" . $producto["cantidad"] . "</td>";
                    echo "<td>" . number_format($producto["precio"], 2) . " €</td>";
                    echo "<td>" . number_format($subtotal, 2) . " €</td>";
                    echo "<td>-" . number_format($descuento, 2) . " € (" . $porcentajeDescuento . "%)</td>";
                    echo "<td>" . number_format($iva, 2) . " € (" . $producto["iva"] . "%)</td>";
                    echo "<td><strong>" . number_format($totalProducto, 2) . " €</strong></td>";
                    echo "</tr>";
                }
                echo "</table>";
                // 6. Resumen final (fuera del foreach)
                $baseImponible = $totalSinDescuento - $totalDescuentos;
                $totalFinal = $baseImponible + $totalIva;
                echo "<h2>Resumen</h2>";
                echo "<p>Subtotal (sin descuentos): " . number_format($totalSinDescuento, 2) . " €</p>";
                echo "<p>Descuentos aplicados: -" . number_format($totalDescuentos, 2) . " €</p>";

                echo "<p>Base imponible: " . number_format($baseImponible, 2) . " €</p>";

                echo "<p>IVA: " . number_format($totalIva, 2) . " €</p>";

                echo "<h3>TOTAL A PAGAR: " . number_format($totalFinal, 2) . " €</h3>";
            }
            echo '<p><a href="Ejercicios_php.html">Volver a la cesta</a></p>';

        } else {
            echo "<p>Debes enviar el formulario.</p>";
        }
        ?>
    </div>
</body>

</html>