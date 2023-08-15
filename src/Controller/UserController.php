<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\DependencyInjection;


class UserController extends AbstractController
{
    #[Route(path: '/api/user/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(
        Request $request,
        UserPasswordHasherInterface $passwordEncoder,
        UserRepository $userRepository
    ): Response {
        // Get the content of the request body
        $content = $request->getContent();

        // Decode the JSON data
        $data = json_decode($content, true);

        // Check if email and password fields are present and not null
        if (!isset($data['email']) || !isset($data['password'])) {
            throw $this->createNotFoundException('Missing email or password');
        }

        // Extract email and password from the data
        $email = $data['email'];
        $password = $data['password'];

        // Query the database for the user with the given email
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            throw new AuthenticationException('User not found');
        }

        // Check if the provided password matches the hashed password in the database
        if (!$passwordEncoder->isPasswordValid($user, $password)) {
            throw new AuthenticationException('Invalid password');
        }

        // Replace this with your actual JWT token generation logic
        // $token = 'your_generated_jwt_token_here';

        return $this->json([
            'message' => 'User registered successfully',
            'user' => $user->getEmail(),
            'lastname' => $user->getLastname(),
            'roles' => $user->getRoles()
            // 'token' => $token,
        ]);
    }

    #[Route(path: '/api/user/register', name: 'api_register', methods: ['POST'])]
    public function apiRegister(
        Request $request,
        UserPasswordHasherInterface $passwordEncoder,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // Get the content of the request body
        $content = $request->getContent();

        // Decode the JSON data
        $data = json_decode($content, true);

        // Check if all required attributes are present in the request body
        $requiredAttributes = ['email', 'password', 'lastname', 'firstname', 'address', 'zipcode', 'city'];
        foreach ($requiredAttributes as $attribute) {
            if (!isset($data[$attribute])) {
                throw new \InvalidArgumentException(sprintf('Missing %s attribute', $attribute));
            }
        }

        // Check if user with the same email already exists
        $existingUser = $userRepository->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            throw new \Exception('User with this email already exists');
        }

        // Create a new user entity
        $user = new User();
        $user->setEmail($data['email']);
        $user->setLastname($data['lastname']);
        $user->setFirstname($data['firstname']);
        $user->setAddress($data['address']);
        $user->setZipcode($data['zipcode']);
        $user->setCity($data['city']);

        // Hash and set the user's password
        $hashedPassword = $passwordEncoder->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Set other user properties as needed

        // Persist the user to the database

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();


        // Retrieve the user from the database using the UserRepository
        $registeredUser = $userRepository->findOneBy(['email' => $user->getEmail()]);

        if (!$registeredUser) {
            throw new AuthenticationException('User not found after registration');
        }

        return $this->json([
            'message' => 'User registered successfully',
            'user' => $registeredUser->toArray()
        ]);
    }
}
