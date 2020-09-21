<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enumeration\NavigationEnumerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage() {
        return $this->render(
            'main/index.html.twig',
            [
                'navigation' => NavigationEnumerator::$navigation
            ]
        );
    }
}