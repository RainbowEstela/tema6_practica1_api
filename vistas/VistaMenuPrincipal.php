<?php
    namespace TripleTriad\vistas;

    class VistaMenuPrincipal {
        public static function render() {
        
            include("cabecera.php");


          //contenido principal
          echo' <main class="container ">';
          echo '
          <div class="d-flex justify-content-center p-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Filtrar</button>  
          </div>
          ';
        ?>

        <div class="cotainer-fluid" id="contenedorTarjetas">
          <div class="d-flex flex-row flex-wrap justify-content-center">
                <h3>Cargando cartas...</h3>
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
            const response = await fetch("./index.php?accion=llamarAPI&idStart=1&idFin=20");
            const data = await response.text();

            console.log(data);

            document.getElementById("contenedorTarjetas").innerHTML = data;
        }



      //Botones prev y next de paginación
      document.getElementById("contenedorTarjetas").onclick=  async function(e) {
        
        let botonPrev = e.target.closest("li[id=prev]");
		    if (botonPrev) {
          console.log(botonPrev.getAttribute('inicio'));
          let inicio = botonPrev.getAttribute('inicio');
          let fin = botonPrev.getAttribute('fin');
          
          if (inicio < 1) {
            inicio = 1;
            fin = 20;
          }
            

          const response = await fetch("./index.php?accion=llamarAPI&idStart="+inicio+"&idFin="+fin);
          const data = await response.text();
          document.getElementById("contenedorTarjetas").innerHTML = data;
        }

        let botonNext = e.target.closest("li[id=next]");
		    if (botonNext) {
          let inicio = botonNext.getAttribute('inicio');
          let fin = botonNext.getAttribute('fin');
 
          const response = await fetch("./index.php?accion=llamarAPI&idStart="+inicio+"&idFin="+fin);
          const data = await response.text();
          document.getElementById("contenedorTarjetas").innerHTML = data;
        }
      };
</script>

<?php


          include("pie.php");
        }
    }

?>