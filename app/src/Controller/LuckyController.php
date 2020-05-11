<?php

namespace App\Controller;

// src/Controller/LuckyController.php

// ...
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class LuckyController.
 */
class LuckyController extends AbstractController
{
    /**
     * @Route("/liczba")
     */

    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
