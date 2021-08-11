<?php
namespace Plinct\Soloine\Factory;

use JetBrains\PhpStorm\Pure;
use Plinct\Soloine\Soloine;

class SoloineFactory
{

    #[Pure] public static function created(): Soloine {
        return new Soloine();
    }
}