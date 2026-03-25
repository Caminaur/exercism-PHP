<?php

declare(strict_types=1);

class ZebraPuzzle
{
    public function waterDrinker(): string
    {
        throw new \BadMethodCallException(sprintf('Implement the %s method', __FUNCTION__));
    }

    public function zebraOwner(): string
    {
        throw new \BadMethodCallException(sprintf('Implement the %s method', __FUNCTION__));
    }
}


// [
//     [Norwegian,    yellow,    Mascota,     Bebida,       painter]    // Primera casa
//     [Nacionalidad, blue,      Horse,       Bebida,       Hobby]      // Segunda casa
//     [Nacionalidad, colorDeCasa, Mascota,     milk,         Hobby]      // casa del medio
//     [Nacionalidad, colorDeCasa, Mascota,     Bebida,       Hobby]    // casa del medio
//     [Nacionalidad, colorDeCasa, Mascota,     Bebida,       Hobby]    // casa del medio

//     [Spaniard,     colorDeCasa, dog,         Bebida,     Hobby]
//     [Englishman, red,         Mascota,     Bebida,     Hobby]
//     [Ukrainian,    colorDeCasa, Mascota,     tea,        Hobby]


// son contiguos
//     [Nacionalidad, ivory , Mascota, Bebida, Hobby]
//     [Nacionalidad, green, Mascota, coffee, Hobby]


//     [Nacionalidad, colorDeCasa, snail, drinks, dancing]

// contiguos
//     [Nacionalidad, colorDeCasa, Mascota, drinks, reading] 
//     [Nacionalidad, colorDeCasa, fox, drinks, Hobby] 
// ]

//     [Nacionalidad, colorDeCasa, Mascota, orange juice, football]
//     [Japanese, colorDeCasa, Mascota, drinks, chess]

// the second house is blue




// Categoría Opción 1 Opción 2 Opción 3 Opción 4 Opción 5
// Casa Casa 1 Casa 2 Casa 3 Casa 4 Casa 5
// Color Red Green Ivory Yellow Blue
// Nacionalidad Englishman Spaniard Ukrainian Norwegian Japanese
// Mascota Dog Snail Fox Horse Zebra
// Bebida Coffee Tea Milk Orange juice Water
// Actividad Dancing Painting Reading Football Chess

// https://www.youtube.com/watch?v=nZb637zKX4E