<?php
    namespace TripleTriad\vistas;


    class VistaAPICard {
        public static function render($resObj,$idInicio,$idFin,$activarPaginacion) {

            if($activarPaginacion) {
                echo'
                <div class="d-flex flex-row flex-wrap justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" inicio="'.(intval($idInicio) - 20).'" fin="'.(intval($idFin) - 20).'" id="prev"><a class="page-link" href="#" >Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">'.$idInicio.' - '.$idFin.'</a></li>
                        <li class="page-item" inicio="'.(intval($idInicio) + 20).'" fin="'.(intval($idFin) + 20).'" id="next"><a class="page-link" href="#" >Next</a></li>
                    </ul>
                </nav>
                </div>
                ';
            }
            


            echo'<div class="d-flex flex-row flex-wrap justify-content-center">';

            foreach($resObj->results as $carta) {

                echo '
                
                    <div class="card m-1" style="width: 18rem;">
                        <img src="'.$carta->image.'" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">'.$carta->name.'</h5>
                            <p class="card-text">'.$carta->description.'</p>
                            <a href="#" class="btn btn-primary" tipo="carta" idCarta="'.$carta->id.'">Detalles</a>
                        </div>
                    </div>
                   
                ';

            }

            echo'</div>';

        }
    }


?>

