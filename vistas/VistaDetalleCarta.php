<?php

namespace TripleTriad\vistas;

class VistaDetalleCarta
{
    public static function render($resObj, $comentarios, $userName)
    {
        echo '
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-info">' . $resObj->stars . '&#11088</strong>
                        <h3 class="mb-0">' . $resObj->name . '</h3>
                        <div class="mb-1 text-body-secondary">Patch: ' . $resObj->patch . '</div>
                        <p class="card-text mb-auto">' . $resObj->description . '</p>
                        
                        <h4 class="card-text mb-auto text-success pt-2">Obtenida por</h4>
                        <div class="progress">
                            
                            <div class="progress-bar" role="progressbar" style="width: ' . $resObj->owned . ';" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">' . $resObj->owned . '</div>
                        </div>
                        
                        <h4 class="card-text mb-auto text-success pt-2">Medios de obtencion</h4>
                        <p>Npcs: ';
        //pintar todos los npcs
        $npcsNameArray = [];

        foreach ($resObj->sources->npcs as $npc) {
            array_push($npcsNameArray, $npc->name);
        }

        if (count($npcsNameArray) > 0) {
            $npcsNameString = implode(", ", $npcsNameArray);

            echo $npcsNameString;
        } else {
            echo 'Ninguno';
        }


        echo '
                        </p>
                        <p>Packs: ';
        //pintar todos los packs
        $packsNameArray = [];

        foreach ($resObj->sources->packs as $pack) {
            array_push($packsNameArray, $pack->name);
        }

        if (count($packsNameArray) > 0) {
            $packsNameString = implode(", ", $packsNameArray);

            echo $packsNameString;
        } else {
            echo 'Ninguno';
        }

        echo '
                        </p>
                        

                        <p>Drops: ';
        //pintar los drops
        $dropsNameArray = [];

        foreach ($resObj->sources->drops as $drop) {
            array_push($dropsNameArray, $drop);
        }

        if (count($dropsNameArray) > 0) {
            $dropsNameString = implode(", ", $dropsNameArray);

            echo $dropsNameString;
        } else {
            echo 'Ninguno';
        }

        echo '
                        </p>
                        <p>Purchase: ';
        //pintar el precio si tiene
        if ($resObj->sources->purchase !== null) {
            echo $resObj->sources->purchase . 'MGP';
        } else {
            echo 'No se puede comprar';
        }
        echo '
                        </p>
                        <a href="' . $resObj->link . '" class="icon-link gap-1 icon-link-hover link">
                            pagina oficial
                        </a>
                    </div>
                    <div class="col-auto d-lg-block">
                        <img class="bd-placeholder-img" width="200" height="250" src="' . $resObj->image . '" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            
                        </img>
                        <p class="card-text mb-auto text-center">' . $resObj->number . '</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border rounded d-flex flex-column p-2">
            <div class="d-flex p-2"><h3 class=" pe-2">Comentarios </h3>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#comentarios">
                +
                </button>
            </div>';

        foreach ($comentarios as $comentario) {
            echo '
                <div class="border rounded p-2">
                    <h4>' . $comentario->getNick() . '</h4>
                    <p>' . $comentario->getComentario() . '</p>
                </div>
                ';
        }




        echo '</div>





        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="comentarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">Publicar comentario como <span class="text-danger">' . $userName . '</span></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addComentarioForm">
                        <input type="hidden" name="nick" id="nick" value="' . $userName . '" />
                        <input type="hidden" name="idCard" id="idCard" value="' . $resObj->id . '" />
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" name="comentario" id="comentario"></textarea>
                            <label for="comentario">Comentario</label>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                        <button type="button" class="btn btn-primary" tipo="nuevoComentario">publicar</button>
                    </div>
                </div>
            </div>
        </div>

        ';
    }
}
