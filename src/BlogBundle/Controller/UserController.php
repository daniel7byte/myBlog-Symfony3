<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Users;
use BlogBundle\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    private $session;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    public function loginAction(Request $request)
    {

        if ($this->getUser()){
            return $this->redirectToRoute('blog_homepage');
        }

        $authenticationUtils = $this->get("security.authentication_utils");
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $userRepo = $em->getRepository("BlogBundle:Users");
                $user_count = $userRepo->findOneBy(["email" => $form->get("email")->getData()]);
                if(count($user_count) == 0){
                    $user = new Users();
                    $user->setName($form->get("name")->getData());
                    $user->setSurname($form->get("surname")->getData());
                    $user->setEmail($form->get("email")->getData());

                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());

                    $user->setPassword($password );
                    $user->setRole("ROLE_USER");
                    $user->setImagen(null);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "Se creo el usuario";
                    } else {
                        $status = "No se creo el usuario";
                    }
                }else{
                    $status = "El usuario ya esta creado";
                }
            } else {
                $status = "No se creo el usuario";
            }
            $this->session->getFlashBag()->add("status", $status);
        }

        return $this->render("BlogBundle:User:login.html.twig", [
            "error" => $error,
            "last_username" => $lastUsername,
            "form" => $form->createView()
        ]);
    }
}
