<?php

namespace TripleTriad\vistas;

class VistaMenuPrincipal
{
  public static function render()
  {

    include("cabecera.php");


    //contenido principal
    echo ' <main class="container ">';
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
                  <h5 class="modal-title" id="exampleModalLabel">Parámetros de busqueda</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                <form id="filtarForm">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Dodo">
                    <label for="name">Nombre de la carta</label>
                  </div>

                  <div class="form-floating">
                    <select class="form-select py-3" id="patch" name="patch" aria-label="Default select example">
                      <option value="" selected>--Expansión--</option>
                      <option value="2." >A Realm Reborn</option>
                      <option value="3.">Heavenward</option>
                      <option value="4.">Stormblood</option>
                      <option value="5.">ShadowBringers</option>
                      <option value="6.">Endwalker</option>
                    </select>
                  </div>

                  <div class="form-floating">
                    <input type="number" class="form-control" id="stars" name="stars" min="1" max="5">
                    <label for="stars">estrellas</label>
                  </div>

                </form>



                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="button" name="accion" value="llamarAPI" form="filtarForm" id="filtrarCartas">filtrar</button>
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

      //boton de filtrar
      document.getElementById("filtrarCartas").onclick = async function() {
        console.log("boton");

        let myModal = document.getElementById('exampleModal');
        let modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        const datos = new FormData(document.getElementById("filtarForm"));
        datos.append("accion", "llamarAPI");

        const response = await fetch("./index.php", { //Fetch hace la petición
          method: 'POST', // *GET, POST, PUT, DELETE, etc.
          body: datos
        });

        document.getElementById("contenedorTarjetas").innerHTML = await response.text();
      } 
      //fin boton filtrar


      document.getElementById("contenedorTarjetas").onclick = async function(e) {

        //Botones prev y next de paginación
        let botonPrev = e.target.closest("li[id=prev]");
        if (botonPrev) {
          console.log(botonPrev.getAttribute('inicio'));
          let inicio = botonPrev.getAttribute('inicio');
          let fin = botonPrev.getAttribute('fin');

          if (inicio < 1) {
            inicio = 1;
            fin = 20;
          }


          const response = await fetch("./index.php?accion=llamarAPI&idStart=" + inicio + "&idFin=" + fin);
          const data = await response.text();
          document.getElementById("contenedorTarjetas").innerHTML = data;
        }
        //fin boton prev


        //boton next
        let botonNext = e.target.closest("li[id=next]");
        if (botonNext) {
          let inicio = botonNext.getAttribute('inicio');
          let fin = botonNext.getAttribute('fin');

          const response = await fetch("./index.php?accion=llamarAPI&idStart=" + inicio + "&idFin=" + fin);
          const data = await response.text();
          document.getElementById("contenedorTarjetas").innerHTML = data;
        }
        //fin boton next

        //boton detalle
        let botonDetalle = e.target.closest("a[tipo=card]");
        if(botonDetalle) {
          console.log(botonDetalle.getAttribute("idCarta"));
        }

        //fin boton detalle

      };
    </script>

<?php


    include("pie.php");
  }
}

?>