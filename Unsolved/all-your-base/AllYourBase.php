<?php

declare(strict_types=1);

function rebase(int $oldBase, array $sequence, int $base)
{
    // Validamos las bases
    if ($oldBase<2) throw new InvalidArgumentException("input base must be >= 2");
    if ($base<2) throw new InvalidArgumentException("output base must be >= 2");

    $decimal = 0;
    $k = 0;

    // Lo transformamos en decimal
    for ($i=count($sequence)-1; $i >= 0 ; $i--) { 
        // digito de la secuencia
        $digit = $sequence[$k];

        // validez del digito
        if ($digit < 0 || $digit >= $oldBase) throw new InvalidArgumentException('all digits must satisfy 0 <= d < input base');

        $decimal += ($digit * pow($oldBase,$i)); 
        
        $k++;
    }

    // si da 0 ya podemos retornar
    if ($decimal==0) return [0];

    // si debemos retornar base 10 la devolvemos nomas
    if ($base==10) {
        $array_resp = array_map("intval",str_split(strval($decimal))); // lo transformamos en un array
        return $array_resp;
    } else{

        // vamos a transformar de decimal a la base objetivo
        $result = [];

        // Es necesario calcular el modulo del numero en decimal por la base a la que lo queremos transformar
        // Acumulamos los restos de esa cuenta en un array
        while ($decimal > 0){
            $residuo = $decimal % $base;  
            // utilizamos intval para redondear los valores antes de seguir calculando
            $result[] = intval($residuo); 
            $decimal = intval(($decimal / $base)); // necesitamos redondear
        }

        // Finalmente debemos revertirlo para que de el resultado correcto
        return array_reverse($result);
    }
}
