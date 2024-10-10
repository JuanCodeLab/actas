<?php
include('../src/conexion.php');
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro </title>
    <link rel="stylesheet" href="../css/style.css">
    </head>
<body>
    
    <div class="sidebar">
        <ul class="nav-list">
            <li>
                <a class="nav-img" href="#">
                    <img  src="../img/verificar.png" alt="registros">
                </a>
            </li>
            <li>
                <a class="nav-img" href="#llaves">
                  <img  src="../img/llave.png" alt="llaves">
                </a>
            </li>
            <li>
                <a class="nav-img" href="#cacceso">
                  <img  src="../img/puerta.png" alt="control de acceso">
                </a>
            </li>
            <li>
                <a class="nav-img" href="#incendio">
                  <img  src="../img/incendio.png" alt="control de incendios">
                </a>
            </li>
            <li>
                <a class="nav-img" href="#cazul">
                  <img  src="../img/clave.png" alt="clave azul">
                </a>
            </li>
        </ul>
    </div>

    <button onclick="topFunction()" id="scrollToTopBtn" title="Ir al inicio">↑</button>
    
    <div class="content" id="registro">
        <small style="color: yellow;">Version alfa 1.1.5</small>  
        <h1>Registro de cambio de turno</h1>
        <p>Presiona el boton de la derecha para realizar un registro.</p>
              
        <a href="#openModal" class="boton">
            <button>
                Nuevo Registro +
            </button>
        </a>

        <form class="form-inline" action="" method="post" enctype="multipart/form-data">
          <div class="input-group">
            <input type="date" style="width: 200px;" class="input" name="Fecha" placeholder="Fecha" required/>
            <input type="submit" class="btn aprobado" name="search" value="Buscar"/>
            
          </div>          
        </form>

        <a href="index.php" >
            <button class="btn alerta" >
                Listado
            </button>
        </a>

          <table class="custom-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Entrega</th>
                    <th>Recibe</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
              if (!isset($_POST['search'])) {
                  $query = "SELECT * FROM Registro ORDER BY Fecha DESC LIMIT 30";
              } else {
                  $Fecha = $_POST['Fecha'];
                  $query = "SELECT * FROM Registro WHERE Fecha LIKE '%$Fecha%'";
              }

              $ret = mysqli_query($con, $query);
              $num = mysqli_num_rows($ret);

              if ($num > 0) {
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($ret)) {
                      ?>
                      <tr>
                          <td><?php echo $row['Fecha']; ?></td>
                          <td><?php echo $row['Entrega']; ?></td>
                          <td><?php echo $row['Recibe'] ? $row['Recibe'] : '<span style="color: darkred; font-size: 12px;">No firmado</span>'; ?></td>
                          <td>
                            
                            <a href="#Leer" class="btn-variant" onclick="showModal(
                                '<?php echo addslashes(htmlspecialchars($row['Fecha'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($row['Entrega'])); ?>', 
                                '<?php echo addslashes(htmlspecialchars($row['Recibe'] ? $row['Recibe'] : 'no')); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['CC'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['CCTV'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['C_ACC'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['PAB'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['UPC'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['P_Superiores'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['Incendio'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['Central_Termica'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['Data_Center'] ?? ''))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['Comentarios'] ? $row['Comentarios'] : 'No hay comentarios'))); ?>', 
                                '<?php echo addslashes(htmlspecialchars(str_replace(array("\r", "\n"), ' ', $row['Observaciones'] ? $row['Observaciones'] : 'No hay observaciones'))); ?>'
                            )">Leer</a>





                            <a href="#modalFirmar" class="btn-variant firmar" onclick="openModal('<?php echo $row['id']; ?>')">Firmar</a>
                          </td>
                      </tr>
                      <?php
                      $cnt = $cnt + 1;
                  }
              } else {
                  ?>
                  <tr>
                      <td colspan="8">No se encontró el registro de la fecha indicada</td>
                  </tr>
                  <?php
              }
              ?>
            </tbody>
          </table>
        
        <div id="Leer" class="modalDialog">
            <div>
                <a href="#close" title="Close" class="close">x</a>
                <!-- Aquí se mostrará el contenido dinámico del registro -->
                <h2>Detalle del Registro</h2>
                <p><strong>Fecha:</strong> <span id="leerFecha"></span></p>
                <p><strong>Creado por:</strong> <span id="leerEntrega"></span></p>
                <p><strong>Firmado por:</strong> <span id="leerRecibe"></span> <span id="noFirmado" style="color: red;"></span></p>
                
                <div class="RDetalles" id="registroDetalles"></div>
            </div>
          </div>


          <div id="modalFirmar" class="modalDialog">
            <div>
                <a href="#close" title="Close" class="close">x</a>
                <h2>Firmar</h2>
                <p id="modalTexto">Ingrese el nombre de usuario que firmará la entrega de este turno</p>

                <form action="firmar-turno.php" method="POST">
                    <input type="hidden" name="turno_id" id="turno_id" value="">
                    <select name="usuario_firma" class="input" required>
                        <option value="">Seleccionar usuario</option>
                        <option value="Sebastian">Sebastian H.</option>
                        <option value="Cristofer">Cristofer S.</option>
                        <option value="Christian">Christian Q.</option>
                        <option value="Juan">Juan D.</option>
                        <option value="Patricio">Patricio G.</option>
                        <option value="Gerardo">Gerardo P.</option>
                    </select>
                    <br><br>
                    <input type="submit" class="btn aprobado" value="Firmar">
                </form>
            </div>
        </div>



        <div id="openModal" class="modalDialog">
            <div>
                <a href="#close" title="Close" class="close">x</a>     
                          
                <h2>Verificacion Operacion de Equipos Criticos</h2>
                <p>Formulario de verificacion de estado de operacion de equipos. 
                Dentro de este formulario debe indicar toda observacion relevante para ser informada a su compañero el cual recibira el turno</p>
            

                <form  class="form-inline" action="actas.php" method="post" enctype="multipart/form-data">
    
                    <div class="input-group">
                        <input type="date" class="input" name="Fecha" placeholder="Fecha" required/>
                        <select name="Entrega" class="input" required >
                            <option value="">Seleccionar usuario</option>
                            <option value="Sebastian">Sebastian H.</option>
                            <option value="Cristofer">Cristofer S.</option>
                            <option value="Christian">Christian Q.</option>
                            <option value="Juan">Juan D.</option>
                            <option value="Patricio">Patricio G.</option>
                            <option value="Gerardo">Gerardo P.</option>
                        </select>
                    </div>

                    <br>
                    <p>Servidores de Control</p>
                        <textarea class="input textarea-expand" name="CC" placeholder="Servidores de Control"></textarea><br>
                    <p>Servidores de CCTV</p>
                        <textarea class="input textarea-expand" name="CCTV" placeholder="Servidores de CCTV"></textarea><br>
                    <p>Servidores de Control de Acceso</p>
                        <textarea class="input textarea-expand" name="C_ACC" placeholder="Control de Acceso"></textarea><br>
                    <p>Pabellones</p>
                        <textarea class="input textarea-expand" name="PAB" placeholder="Climatizacion Pabellones"></textarea><br>
                    <p>UPC</p>                
                        <textarea class="input textarea-expand" name="UPC" placeholder="Climatizacion UPC"></textarea><br>
                    <p>UMAS Pisos 7 y 8</p>
                        <textarea class="input textarea-expand" name="P_Superiores" placeholder="UMAS P7 y P8"></textarea><br>
                    <p>Sistemas contra incendio</p>
                        <textarea class="input textarea-expand" name="Incendio" placeholder="Sistemas contra Incendio"></textarea><br>
                    <p>Central Termica</p>
                        <textarea class="input textarea-expand" name="Central_Termica" placeholder="Estado Central Termica"></textarea><br>
                    <p>Data Center</p>
                        <textarea class="input textarea-expand" name="Data_Center" placeholder="Estado Data Center 1 y 2"></textarea>
                    <br>
                        <textarea class="input textarea-expand" name="Comentarios" placeholder="Comentarios"></textarea>
                    <br>
                    <textarea class="input textarea-expand" name="Observaciones" placeholder="Observaciones"></textarea>
            
                    <input type="submit" class="btn aprobado" name="submit" value="Entregar"/>
                </form>
            </div>
        </div>
    </div>
    <script src="../scripts/script.js"></script>
</body>
</html>
