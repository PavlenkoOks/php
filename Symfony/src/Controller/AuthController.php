<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController extends AbstractController
{
    private JWTTokenManagerInterface $jwtManager;
    private EntityManagerInterface $entityManager;

    public function __construct(JWTTokenManagerInterface $jwtManager, EntityManagerInterface $entityManager)
    {
        $this->jwtManager = $jwtManager;
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['role'] ?? 'Client';

            $existingUser = $this->entityManager->getRepository(User::class)->findByEmail($email);
            if ($existingUser) {
                return $this->render('auth/register.html.twig', [
                    'error' => 'Користувач з таким email вже існує.',
                ]);
            }

            $user = new User($email, $password, $role);
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/register.html.twig');
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $email = $data['email'];
            $password = $data['password'];

            $user = $this->entityManager->getRepository(User::class)->findByEmail($email);

            if (!$user || !$user->checkPassword($password)) {
                $error = 'Невірні дані для входу.';
                return $this->render('auth/login.html.twig', [
                    'error' => $error,
                ]);
            }

            $token = $this->jwtManager->create($user);
            $request->getSession()->set('jwt_token', $token);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('auth/login.html.twig');
    }
}

