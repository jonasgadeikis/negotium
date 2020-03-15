<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\User\UserCreator;
use App\Utilities\SerializationTrait;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    use SerializationTrait;

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserCreator $userCreator
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function register(Request $request, UserCreator $userCreator)
    {
        $user = $this->deserialize($request->getContent(), User::class, 'json');
        $response = $userCreator->create($user);

        return $this->json($response, 201);
    }
}
