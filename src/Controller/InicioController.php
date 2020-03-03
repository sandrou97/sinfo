<?php
    
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class InicioController extends AbstractController
    {

        /**
         * @Route("/", name="inicio")
         */
        public function inicio()
        {
            $params = array('fecha' => date('d-m-y'));
            return $this->render('inicio.html.twig', ['fecha' => $params]);
        }
    }

?>