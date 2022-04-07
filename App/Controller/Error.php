<?php

namespace App\Controller;

class Error implements Controller
{
    public function render()
    {
        echo 'Page non trouvée';
    }
}