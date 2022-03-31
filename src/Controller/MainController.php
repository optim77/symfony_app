<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * controller to service main page
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('main.html.twig');
    }

    /**
     * @Route ("/category/{slug}", name="category")
     */
    public function category(string $slug): Response{
        return $this->render('category.html.twig');
    }


    /**
     * @Route ("/login", name="login")
     */
    public function login(): Response{
        $fill = new User();
        $form = $this->createForm(User::class, $fill);
        return $this->render('login.html.twig', ['form' => $form]);
    }

    /**
     * @Route("/sign_up", name="sign_up")
     */
    public function sign_up(): Response{
        return $this->render('sing_up.html.twig');
    }

    /**
     * @Route ("/contact", name="contact")
     */
    public function contact() : Response{
        return $this->render('contact.html.twig');
}
}
