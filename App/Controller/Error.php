<?php

declare(strict_types=1);

namespace App\Controller;

class Error implements Controller
{
    public function render(): void
    {
        echo 'Page non trouvée';
    }
}
