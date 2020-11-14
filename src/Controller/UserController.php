<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User\User;
use App\Form\UserSettingFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController.
 *
 * @Route(name="app_user_", path="/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route(name="view", path="/{userName?}")
     *
     * @param string|null $userName
     *
     * @return Response
     */
    public function view(?string $userName = null): Response
    {
        $settingsForm = null;
        $user = null;
        $currentUser = $this->getUser();

        if (
            $currentUser instanceof User
            && (
                !$userName
                || $currentUser->getUserName() === $userName
            )
        ) {
            $user = $currentUser;
        }

        if (!$user instanceof User) {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->getOneByUserName($userName);
        }

        $settingsForm = $this->createForm(
            UserSettingFormType::class,
            UserDTO::create($user)
        );

        return $this->render(
            'main/profile/view.html.twig',
            [
                'user' => $user,
                'settingsForm' => $settingsForm->createView(),
            ]
        );
    }

    /**
     * @Route(name="settings", path="/{userName}/settings")
     * @IsGranted("ROLE_USER")
     *
     * @param string $userName
     *
     * @return Response
     */
    public function setting(string $userName): Response
    {
        $settingsForm = null;
        $user = null;
        $currentUser = $this->getUser();

        if ($currentUser instanceof User) {
            $user = $currentUser;
        }

        if (!$user instanceof User) {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->getOneByUserName($userName);
        }

        $settingsForm = $this->createForm(
            UserSettingFormType::class,
            UserDTO::create($user)
        );

        return $this->render(
            'main/profile/settings.html.twig',
            [
                'settingsForm' => $settingsForm->createView(),
            ]
        );
    }
}
