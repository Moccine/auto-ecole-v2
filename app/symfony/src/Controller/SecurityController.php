<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Token;
use App\Entity\User;
use App\Form\Security\LoginType;
use App\Form\Security\RequestType;
use App\Form\Security\ResetType;
use App\Form\Security\UserType;
use App\Manager\TokenManager;
use App\Manager\UserManager;
use App\Model\UserRequestModel;
use App\Model\UserResetModel;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use App\Service\Security\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration", methods={"GET", "POST"})
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     */
    public function registration(
        Request $request,
        UserManager $userManager
    ): Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->create($user);
         //   return $this->redirectToRoute('user_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/registration/confirm/{value}", name="registration_confirm", methods={"GET","POST"})
     * @param Request $request
     * @param TokenService $tokenService
     * @param UserManager $userManager
     * @param TokenRepository $repository
     * @return Response
     */
    public function resetConfirm(
        Request $request,
        TokenService $tokenService,
        UserManager $userManager,
    TokenRepository $repository
    ): Response {

        $token = $repository->findOneBy([
            'value' =>  $request->attributes->get('value')
        ]);
        if (!$token instanceof Token) {
            throw $this->createNotFoundException();
        }
        if (!$tokenService->isValid($token, Token::TTL_RESET)) {
            throw $this->createNotFoundException();
        }

        $userManager->registrationConfirm($token);

        return $this->render('security/registrationConfirm.html.twig');
    }

    /**
     * @Route("/login", name="user_login", methods={"GET","POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginType::class, [
            'email' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/password/request", name="user_request", methods={"GET","POST"})
     * @param Request $request
     * @param TokenManager $tokenManager
     * @param UserRepository $userRepository
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function request(
        Request $request,
        TokenManager $tokenManager,
        UserRepository $userRepository,
        TranslatorInterface $translator
    ): Response {
        $userRequest = new UserRequestModel();

        $form = $this->createForm(RequestType::class, $userRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneByEmail($userRequest->getEmail());

            if ($user instanceof User) {
                $tokenManager->create(Token::TYPE_RESET, $user);
            }

            $this->addFlash('success', $translator->trans('app.flash.updatePassword'));
        }

        return $this->render('security/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/password/reset/{value}", name="user_reset", methods={"GET","POST"})
     * @param Request $request
     * @param Token $token
     * @param TokenService $tokenService
     * @param UserManager $userManager
     * @return Response
     */
    public function reset(
        Request $request,
        Token $token,
        TokenService $tokenService,
        UserManager $userManager
    ): Response {
        if (!$tokenService->isValid($token, Token::TTL_RESET)) {
            throw $this->createNotFoundException();
        }

        $userReset = new UserResetModel();

        $form = $this->createForm(ResetType::class, $userReset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->resetPassword($token->getUser(), $userReset->getPlainPassword(), $token);

            $this->addFlash(
                'success',
                'app.form.reset.confirmUpdate'
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }
}
