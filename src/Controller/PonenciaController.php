<?php

    namespace App\Controller;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
    use App\Entity\Ponencia;
    use App\Entity\Categoriaponencia;
    use Symfony\Component\Form\Extension\Core\Type\TextType; 
    use Symfony\Component\Form\Extension\Core\Type\IntegerType; 
    use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
    use Symfony\Component\Form\Extension\Core\Type\EntityTpe;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\Extension\Core\Type\HiddenType;
    use Symfony\Component\HttpFoundation\Request;

    class PonenciaController extends AbstractController {


        public function pedir(){
            $pon_rep = $this->getDoctrine()->getRepository(Ponencia::class); 
            $ponencias = $pon_rep->findAll();
            return $ponencias;
        }
        /**
         * @Route("/ponencias", name="ponencias")
         */
        public function inicio()
        {
            return $this->render('lista_ponencias.html.twig', array('ponencias' => $this->pedir()));
        }

        /**
         * @Route("/ponencia/likeup/{id}", name="likeup")
         */
        public function likeup($id){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $pon_rep = $this->getDoctrine()->getRepository(Ponencia::class); 
            $ponencia = $pon_rep->find($id);
            
            if ($ponencia->getLikepo() >= 0)
                {   
                    $ponencia->setLikepoup();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($ponencia); $entityManager->flush();
                    return $this->redirectToRoute('ponencias');
                }

                return $this->redirectToRoute('ponencias');
        }

        /**
         * @Route("/ponencia/likeminus/{id}", name="likeminus")
         */
        public function likeminus($id){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $pon_rep = $this->getDoctrine()->getRepository(Ponencia::class); 
            $ponencia = $pon_rep->find($id);
            
            if ($ponencia->getLikepo() > 0)
                {   
                    $ponencia->setLikepominus();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($ponencia); $entityManager->flush();
                    return $this->redirectToRoute('ponencias');
                }

                return $this->redirectToRoute('ponencias');
        }

        /**
         * @Route("/ponencia/eliminar/{id}", name="eliminarponencia")
         */
        public function eliminar($id){
            $entityManager = $this->getDoctrine()->getManager();
            $pon_rep = $this->getDoctrine()->getRepository(Ponencia::class); 
            $ponencia = $pon_rep->find($id);
            if ($ponencia)
            {
                $entityManager->remove($ponencia); 
                $entityManager->flush();
            }
            return $this->redirectToRoute('ponencias');
        }

        /**
         * @Route("/ponencia/editar/{id}", name="editarponencia")
         */
        public function editar_ponencia(Request $request, $id){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $pon_rep = $this->getDoctrine()->getRepository(Ponencia::class); 
            $ponencia = $pon_rep->find($id);
            $formulario = $this->createFormBuilder($ponencia)
                ->add('id', TextType::class)
                ->add('titulopo', TextType::class)
                ->add('likepo', TextType::class)
                ->add('categoriaponencia', EntityType::class, array('class' => Categoriaponencia::class))
                ->add('save', SubmitType::class, array('label' => 'Modificar')) ->getForm();

                $formulario->handleRequest($request);

                if ($formulario->isSubmitted() && $formulario->isValid())
                {   
                    $ponencia = $formulario->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($ponencia); $entityManager->flush();
                    return $this->redirectToRoute('ponencias');
                }

            return $this->render('editar_ponencia.html.twig', array('formulario' => $formulario->createView()));
        }

        /**
         * @Route("/ponencia/nueva", name="nuevaponencia")
         */
        public function nueva_ponencia(Request $request){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $ponencia = new Ponencia();
            $formulario = $this->createFormBuilder($ponencia)
                ->add('id', HiddenType::class)
                ->add('titulopo', TextType::class)
                ->add('likepo', HiddenType::class)
                ->add('categoriaponencia', EntityType::class, array('class' => Categoriaponencia::class))
                ->add('save', SubmitType::class, array('label' => 'Insertar')) ->getForm();

                $formulario->handleRequest($request);

                if ($formulario->isSubmitted() && $formulario->isValid())
                {   
                    $ponencia = $formulario->getData();
                    $ponencia->setLikepo(0);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($ponencia); $entityManager->flush();
                    return $this->redirectToRoute('ponencias');
                }

            return $this->render('nueva_ponencia.html.twig', array('formulario' => $formulario->createView()));
        }
    }
?>