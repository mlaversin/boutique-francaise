<?php

namespace App\Controller;

use App\Entity\User;
use App\Classes\Mail;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request): Response
    {
        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email) {
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                    ));
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mail = new Mail();
                $content="Bonjour ".$user->getFirstname()."<br>Bienvenue sur la première boutique 100% dédiée au made in France<br><br>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Molestiae ullam delectus sit similique voluptatibus praesentium, odit eius est ipsam. Expedita earum, minus non quis itaque consequatur autem possimus ex illo est ut, nihil blanditiis tempore reiciendis iste rem! Repellendus labore autem, quos maxime cum accusamus quis. Vitae itaque asperiores suscipit.";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur la Boutique Française', $content);

                $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte";
            } else {
                $notification = "L'email que vous avez renseigné existe déja.";
            }
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
