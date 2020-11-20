<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Classes\File\FileUploader;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @Rest\Post(path="/upload")
     * @Rest\View()
     *
     * @param Request $request
     * @param FileUploader $fileUploader
     *
     * @return View
     */
    public function upload(
        Request $request,
        FileUploader $fileUploader
    ): View
    {
        $file = $request->files->get('image');

        if (!$file instanceof UploadedFile) {
            return View::create([
                "success" => 0,
                "file" => null
            ]);
        }

        $filePath = $fileUploader->upload($file);

        return View::create([
            "success" => 1,
            "file" => [
                "url" => "https://events.local/" . $filePath,
                // ... and any additional fields you want to store, such as width, height, color, extension, etc
            ]
        ]);
    }
}