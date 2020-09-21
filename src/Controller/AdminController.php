<?php

namespace App\Controller;

use App\Enumeration\NavigationEnumerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 *
 * @Route(name="app_admin_", path="/admin")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(): Response
    {
        return $this->render(
            'main/admin/index.html.twig'
        );
    }
}