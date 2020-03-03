<?php

    namespace App\Controller;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
    use App\Entity\Taller;
    use App\Entity\Categoriataller;
    use Symfony\Component\Form\Extension\Core\Type\TextType; 
    use Symfony\Component\Form\Extension\Core\Type\IntegerType; 
    use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
    use Symfony\Component\Form\Extension\Core\Type\EntityTpe;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\Extension\Core\Type\HiddenType;
    use Symfony\Component\HttpFoundation\Request;

    class TallerController extends AbstractController {


        public function pedir(){
            $ta_rep = $this->getDoctrine()->getRepository(Taller::class); 
            $taller = $ta_rep->findAll();
            return $taller;
        }
        /**
         * @Route("/talleres", name="talleres")
         */
        public function inicio()
        {
            return $this->render('lista_talleres.html.twig', array('talleres' => $this->pedir()));
        }

        /**
         * @Route("/taller/likeup/{id}", name="likeupta")
         */
        public function likeup($id){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $ta_rep = $this->getDoctrine()->getRepository(Taller::class); 
            $taller = $ta_rep->find($id);
            
            if ($taller->getLiketa() >= 0)
                {   
                    $taller->setLiketaup();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($taller); $entityManager->flush();
                    return $this->redirectToRoute('talleres');
                }

                return $this->redirectToRoute('talleres');
        }

        /**
         * @Route("/taller/likeminus/{id}", name="likeminusta")
         */
        public function likeminus($id){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $ta_rep = $this->getDoctrine()->getRepository(Taller::class); 
            $taller = $ta_rep->find($id);
            
            if ($taller->getLiketa() > 0)
                {   
                    $taller->setLiketaminus();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($taller); $entityManager->flush();
                    return $this->redirectToRoute('talleres');
                }

                return $this->redirectToRoute('talleres');
        }

        /**
         * @Route("/taller/eliminar/{id}", name="eliminartaller")
         */
        public function eliminar($id){
            $entityManager = $this->getDoctrine()->getManager();
            $ta_rep = $this->getDoctrine()->getRepository(Taller::class); 
            $taller = $ta_rep->find($id);
            if ($taller)
            {
                $entityManager->remove($taller); 
                $entityManager->flush();
            }
            return $this->redirectToRoute('talleres');
        }

        /**
         * @Route("/taller/editar/{id}", name="editartaller")
         */
        public function editar_taller(Request $request, $id){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $ta_rep = $this->getDoctrine()->getRepository(Taller::class); 
            $taller = $ta_rep->find($id);
            $formulario = $this->createFormBuilder($taller)
                ->add('id', TextType::class)
                ->add('titulota', TextType::class)
                ->add('liketa', TextType::class)
                ->add('categoriataller', EntityType::class, array('class' => Categoriataller::class))
                ->add('save', SubmitType::class, array('label' => 'Modificar')) ->getForm();

                $formulario->handleRequest($request);

                if ($formulario->isSubmitted() && $formulario->isValid())
                {   
                    $taller = $formulario->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($taller); $entityManager->flush();
                    return $this->redirectToRoute('talleres');
                }

            return $this->render('editar_taller.html.twig', array('formulario' => $formulario->createView()));
        }

        /**
         * @Route("/taller/nuevo", name="nuevotaller")
         */
        public function nuevo_taller(Request $request){
            //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Acceso restringido a administradores');
            $taller = new Taller();
            $formulario = $this->createFormBuilder($taller)
                ->add('id', HiddenType::class)
                ->add('titulota', TextType::class)
                ->add('liketa', HiddenType::class)
                ->add('categoriataller', EntityType::class, array('class' => Categoriataller::class))
                ->add('save', SubmitType::class, array('label' => 'Modificar')) ->getForm();

                $formulario->handleRequest($request);

                if ($formulario->isSubmitted() && $formulario->isValid())
                {   
                    $taller = $formulario->getData();
                    $taller->setLiketa(0);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($taller); $entityManager->flush();
                    return $this->redirectToRoute('talleres');
                }

            return $this->render('nuevo_taller.html.twig', array('formulario' => $formulario->createView()));
        }
    }
?>