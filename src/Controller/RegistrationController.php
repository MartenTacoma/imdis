<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        LoginFormAuthenticator $authenticator,
        UserPasswordHasherInterface $passwordHasher,
        UrlGeneratorInterface $urlGenerator
    ): Response
    {
        if($this->getParameter('app.registration_status') !== 'open') {
            return $this->render('registration/closed.html.twig');
        } elseif($this->isGranted('ROLE_USER')){
            return $this->render('registration/existing.html.twig');
        } else {
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setPassword($passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                
                $email = new TemplatedEmail();
                $email->from(new Address('info@sodecade-pdf4.org', 'Southern Ocean Decade & Polar Data Forum Week 2021'))
                    ->to($user->getEmail())
                    ->subject('Registration confirmation Southern Ocean Decade & Polar Data Forum Week 2021')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                    ->replyTo(new Address('info@sodecade.org', 'Southern Ocean Decade & Polar Data Forum Week 2021'));
                $context = $email->getContext();
                $context['user'] = $user;

                $email->context($context);

                $this->mailer->send($email);

                $this->addFlash('success', 'Your account has been created. You will receive a confirmation shortly.');
                $passport = new Passport(
                    new UserBadge($user->getEmail()),
                    new PasswordCredentials($form->get('plainPassword')->getData())
                );
                return new RedirectResponse($urlGenerator->generate('user_self'));
            }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        }
    }
}
