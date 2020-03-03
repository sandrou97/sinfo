<?php

    namespace App\Controller;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

    class LoginController extends AbstractController {
        
        /**
        * @Route("/login", name="login", methods={"GET", "POST"}) 
        */
        public function login(AuthenticationUtils $authenticationUtils){ 
            $lastUsername = NULL;
            $error = $authenticationUtils->getLastAuthenticationError(); 
            $lastUsername = $authenticationUtils->getLastUsername();
            return $this->render('login.html.twig', [ 'last_username' => $lastUsername,'error' => $error,]);
        }
}