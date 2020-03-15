<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserCreator
 * @package App\Service\User
 */
class UserCreator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(User $user)
    {
        $existingUser = $this->userRepository->findOneBy(['email' => $user->getEmail()]);

        if ($existingUser) {
            return array(
                'code' => 409,
                'message' => 'User with this email already exists',
            );
        }

        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

        $result = $this->userRepository->save($user);

        return $result;
    }
}