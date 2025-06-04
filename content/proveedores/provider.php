<?php
    $consulta="SELECT id,nombre,numcelular,email,fecha_alta,estado FROM proveedores where estado != 'bajo' order by nombre";
    $result=bd_consulta($consulta);
?>
<script type="text/javascript">
    var nombreAsc = true;
    var numCelularAsc = true;
    var emailAsc = true;
    var fechaAltaAsc = true;

    function asociarEventos() {
        var thNombre = document.getElementById("nombreColumna");
        var thNumCelular = document.getElementById("numCelularColumna");
        var thEmail = document.getElementById("emailColumna");
        var thFechaAlta = document.getElementById("fechaAltaColumna");

        if (thNombre) {
            thNombre.addEventListener("click", ordenarPorNombre);
        }
        if (thNumCelular) {
            thNumCelular.addEventListener("click", ordenarPorNumCelular);
        }
        if (thEmail) {
            thEmail.addEventListener("click", ordenarPorEmail);
        }
        if (thFechaAlta) {
            thFechaAlta.addEventListener("click", ordenarPorFechaAlta);
        }
    }

    function ordenarPorNombre() {
        var tabla = document.getElementsByTagName("table")[0];
        var filas = tabla.getElementsByTagName("tr");

        var inicio = 1;
        var fin = filas.length - 1;
        var numColumnasDatos = 6;

        var matriz = new Array(fin - inicio);

        for (var i = inicio; i < fin; i++) {
            matriz[i - inicio] = new Array(numColumnasDatos);
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    matriz[i - inicio][j] = celdas[j].innerHTML;
                } else {
                    matriz[i - inicio][j] = "";
                }
            }
        }

        for (var i = 0; i < matriz.length - 1; i++) {
            for (var j = i + 1; j < matriz.length; j++) {
                var a = matriz[i][1].toLowerCase();
                var b = matriz[j][1].toLowerCase();

                var condicion = nombreAsc ? (a > b) : (a < b);
                if (condicion) {
                    var temp = matriz[i];
                    matriz[i] = matriz[j];
                    matriz[j] = temp;
                }
            }
        }

        for (var i = inicio; i < fin; i++) {
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    celdas[j].innerHTML = matriz[i - inicio][j];
                }
            }
        }

        var flechas = document.querySelectorAll("span[id^='flecha']");
        flechas.forEach(function(flecha) {
            flecha.innerHTML = "▼";
        });

        var flechaNombre = document.getElementById("flechaNombre");
        if (flechaNombre) {
            flechaNombre.innerHTML = nombreAsc ? "▲" : "▼";
        }

        nombreAsc = !nombreAsc;
    }

    function ordenarPorNumCelular() {
        var tabla = document.getElementsByTagName("table")[0];
        var filas = tabla.getElementsByTagName("tr");

        var inicio = 1;
        var fin = filas.length - 1;
        var numColumnasDatos = 6;

        var matriz = new Array(fin - inicio);

        for (var i = inicio; i < fin; i++) {
            matriz[i - inicio] = new Array(numColumnasDatos);
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    matriz[i - inicio][j] = celdas[j].innerHTML;
                } else {
                    matriz[i - inicio][j] = "";
                }
            }
        }

        for (var i = 0; i < matriz.length - 1; i++) {
            for (var j = i + 1; j < matriz.length; j++) {
                var a = parseFloat(matriz[i][2]);
                var b = parseFloat(matriz[j][2]);

                var condicion = numCelularAsc ? (a > b) : (a < b);
                if (condicion) {
                    var temp = matriz[i];
                    matriz[i] = matriz[j];
                    matriz[j] = temp;
                }
            }
        }

        for (var i = inicio; i < fin; i++) {
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    celdas[j].innerHTML = matriz[i - inicio][j];
                }
            }
        }

        var flechas = document.querySelectorAll("span[id^='flecha']");
        flechas.forEach(function(flecha) {
            flecha.innerHTML = "▼";
        });

        var flechaNumCelular = document.getElementById("flechaNumCelular");
        if (flechaNumCelular) {
            flechaNumCelular.innerHTML = numCelularAsc ? "▲" : "▼";
        }

        numCelularAsc = !numCelularAsc;
    }

    function ordenarPorEmail() {
        var tabla = document.getElementsByTagName("table")[0];
        var filas = tabla.getElementsByTagName("tr");

        var inicio = 1;
        var fin = filas.length - 1;
        var numColumnasDatos = 6;

        var matriz = new Array(fin - inicio);

        for (var i = inicio; i < fin; i++) {
            matriz[i - inicio] = new Array(numColumnasDatos);
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    matriz[i - inicio][j] = celdas[j].innerHTML;
                } else {
                    matriz[i - inicio][j] = "";
                }
            }
        }

        for (var i = 0; i < matriz.length - 1; i++) {
            for (var j = i + 1; j < matriz.length; j++) {
                var a = matriz[i][3].toLowerCase();
                var b = matriz[j][3].toLowerCase();

                var condicion = emailAsc ? (a > b) : (a < b);
                if (condicion) {
                    var temp = matriz[i];
                    matriz[i] = matriz[j];
                    matriz[j] = temp;
                }
            }
        }

        for (var i = inicio; i < fin; i++) {
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    celdas[j].innerHTML = matriz[i - inicio][j];
                }
            }
        }

        var flechas = document.querySelectorAll("span[id^='flecha']");
        flechas.forEach(function(flecha) {
            flecha.innerHTML = "▼";
        });

        var flechaEmail = document.getElementById("flechaEmail");
        if (flechaEmail) {
            flechaEmail.innerHTML = emailAsc ? "▲" : "▼";
        }

        emailAsc = !emailAsc;
    }

    function ordenarPorFechaAlta() {
        var tabla = document.getElementsByTagName("table")[0];
        var filas = tabla.getElementsByTagName("tr");

        var inicio = 1;
        var fin = filas.length - 1;
        var numColumnasDatos = 6;

        var matriz = new Array(fin - inicio);

        for (var i = inicio; i < fin; i++) {
            matriz[i - inicio] = new Array(numColumnasDatos);
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    matriz[i - inicio][j] = celdas[j].innerHTML;
                } else {
                    matriz[i - inicio][j] = "";
                }
            }
        }

        for (var i = 0; i < matriz.length - 1; i++) {
            for (var j = i + 1; j < matriz.length; j++) {
                var a = matriz[i][4];
                var b = matriz[j][4];

                var condicion = fechaAltaAsc ? (a > b) : (a < b);
                if (condicion) {
                    var temp = matriz[i];
                    matriz[i] = matriz[j];
                    matriz[j] = temp;
                }
            }
        }

        for (var i = inicio; i < fin; i++) {
            var celdas = filas[i].getElementsByTagName("td");
            for (var j = 0; j < numColumnasDatos; j++) {
                if (celdas[j]) {
                    celdas[j].innerHTML = matriz[i - inicio][j];
                }
            }
        }

        var flechas = document.querySelectorAll("span[id^='flecha']");
        flechas.forEach(function(flecha) {
            flecha.innerHTML = "▼";
        });

        var flechaFechaAlta = document.getElementById("flechaFechaAlta");
        if (flechaFechaAlta) {
            flechaFechaAlta.innerHTML = fechaAltaAsc ? "▲" : "▼";
        }

        fechaAltaAsc = !fechaAltaAsc;
    }

    window.addEventListener("load", asociarEventos);
</script>

<table>
    <tr>
        <th>#</th>
        <th id="nombreColumna" style="cursor:pointer">Nombre <span id="flechaNombre">▼</span></th>
        <th id="numCelularColumna" style="cursor:pointer">Numero Celular <span id="flechaNumCelular">▼</span></th>
        <th id="emailColumna" style="cursor:pointer">Email <span id="flechaEmail">▼</span></th>
        <th id="fechaAltaColumna" style="cursor:pointer">Fecha Alta <span id="flechaFechaAlta">▼</span></th>
        <th><a href="../base/index.php?op=31">+ &#128218;</a></th>
    </tr>

<?php
    $i=0;
    while($row=mysqli_fetch_assoc($result)){
        $i++;
?>
    <tr>
        <td><?= $i ?></td>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['numcelular'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['fecha_alta'] ?></td>
        <td>
            <a href="../base/index.php?op=32&id=<?=$row['id']?>">&#9997;&#127995;</a>
            <a href="../base/index.php?op=33&id=<?=$row['id']?>">❌</a>
        </td>
    </tr>
<?php } ?>
    <tr>
        <td></td><td></td><td></td><td>El total de provedores es <?=$i?></td><td></td><td></td>
    </tr>
</table>