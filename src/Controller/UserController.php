<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Enumeration\NavigationEnumerator;
use App\Form\UserSettingFormType;
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
            !$userName
            || $currentUser->getUserName() === $userName
        ) {
            $user = $currentUser;
        }

        if (!$user instanceof User) {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->getOneByUserName($userName);
        }

        $settingsForm = $this->createForm(UserSettingFormType::class, UserDTO::create($user))
            ->createView();

        return $this->render(
            'main/profile/view.html.twig',
            [
                'navigation' => NavigationEnumerator::$navigation,
                'user' => $user,
                'userSettingsForm' => $settingsForm,
            ]
        );
    }
}
