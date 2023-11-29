<?php
    namespace TripleTriad\vistas;

    class VistaMenuPrincipal {
        public static function render() {
        
            include("cabecera.php");


          //contenido principal
          echo' <main class="container ">';
          echo '
          <div class="d-flex justify-content-center p-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Añadir</button>  
          </div>
          <div class="d-flex justify-content-end">
            <form class="form-inline" style="width:200px;">
              <div class="d-flex nowrap">
                <input class="form-control" type="number" placeholder="Buscar año" aria-label="Search" name="year" min=0 required>
                <button class="btn btn btn-success" type="submit" name="accion" value="regalosPorYear">Buscar</button>
              </div>
            </form> 
          </div>
          ';
        ?>

        <div class="cotainer-fluid">
            <div class="row" id="contenedorTarjetas">
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>


        
        <?php
          echo '</main>';
          //fin contenido principal

          //modal
          echo '
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Añadir un nuevo Regalo</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                <form action="index.php" method="POST" id="formAddRegalo">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="inputNombre" name="nombre" placeholder="tu nombre" required>
                    <label for="inputNombre">Nombre del regalo</label>
                  </div>

                  <div class="form-floating">
                    <input type="text" class="form-control" id="inputDest" name="destinatario" placeholder="tu nombre" required>
                    <label for="inputDest">Destinatario/a</label>
                  </div>

                  <div class="form-floating">
                    <input type="number" step="any" class="form-control" id="inputPrecio" name="precio" placeholder="tu nombre" min="0" max="9999" required>
                    <label for="inputPrecio">Precio</label>
                  </div>

                  <div class="form-floating">
                    <select class="form-select py-3" name="estado" aria-label="Default select example">
                      <option value="pendiente" selected>Pendiente</option>
                      <option value="comprado">Comprado</option>
                      <option value="envuelto">Envuelto</option>
                      <option value="entregado">Entregado</option>
                    </select>
                  </div>

                  <div class="form-floating">
                    <input type="number" class="form-control" id="inputYear" name="year" placeholder="tu nombre" required>
                    <label for="inputYear">Año</label>
                  </div>

                </form>



                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" name="accion" value="peticionAddRegalo" form="formAddRegalo">Añadir</button>
                </div>
              </div>
            </div>
          </div>
          ';
          //fin modal
?>

<script>
        window.onload = llamarInicio();

        async function llamarInicio() {
            const response = await fetch("./index.php?accion=llamarAPI");
            const data = await response.text();

            console.log(data);

            document.getElementById("contenedorTarjetas").innerHTML = data;
        }
</script>

<?php


          include("pie.php");
        }
    }

?>