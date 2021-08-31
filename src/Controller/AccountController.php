<?php

namespace App\Controller;

use App\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="account")
     */
    public function index(): Response
    {   
        if ($this->getUser()) {
            return $this->render('account/index.html.twig');
        } else {
            $this->redirectToRoute('app_register');
        }
        
    }

    /**
     * @Route("/edit", name="account_edit")
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->redirectToRoute('account');
        }

        return $this->render('account/edit.hmtl.twig', [
            'form' => $form
        ]);
        
    }
}
