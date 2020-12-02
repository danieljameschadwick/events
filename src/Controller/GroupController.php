<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User\Group;
use App\Entity\User\User;
use App\Form\UserSettingFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GroupController.
 *
 * @Route(name="app_group_", path="/group")
 */
class GroupController extends AbstractController
{
    /**
     * @Route(name="view", path="/{name}")
     *
     * @param string $name
     *
     * @return Response
     */
    public function view(string $name): Response
    {
        $group = $this->getDoctrine()
            ->getRepository(Group::class)
            ->getByName($name);

        if (!$group instanceof Group) {
            throw new \InvalidArgumentException(sprintf('Group %s doesn\'t exist.', $name));
        }

        return $this->render(
            'main/group/view.html.twig',
            [
                'group' => $group,
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
