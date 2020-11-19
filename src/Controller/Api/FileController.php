<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FileController.
 *
 * @Route(name="file_", path="/file")
 */
class FileController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/upload")
     * @Rest\View()
     *
     * @param Request $request
     * @param EntityManagerInterface $doctrine
     *
     * @return View
     */
    public function upload(
        Request $request,
        EntityManagerInterface $doctrine
    ): View
    {
        return View::create([]);
    }
}