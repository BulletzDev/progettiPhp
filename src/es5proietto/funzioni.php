<?php
    function media($numeri){
        $somma=array_sum($numeri);
        $count=count($numeri);
        return $somma/$count;
    }
    function stampaRisultato($media){
        return "<p>Lo studente è: ".$media>=6?'Promosso':'Bocciato'."</p>";
    }
?>