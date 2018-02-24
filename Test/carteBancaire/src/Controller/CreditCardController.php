<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Form\CreditCardType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreditCardController extends Controller
{
    /**
     * @Route("/credit/addcard", name="addcard")
     */
    public function addCreditCard(Request $request)
    {
        // 1) build the form
        $creditCard = new CreditCard();
        $form = $this->createForm(CreditCardType::class, $creditCard);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $creditCard->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($creditCard);
            $em->flush();


            return $this->redirectToRoute('mycards');
        }

        return $this->render(
            'pages/addcarte.html.twig',
            array('form' => $form->createView())
        );


    }

    /**
     * @Route("/credit/editcard", name="editcard", options={"expose"=true})
     */
    public function editCreditCard(Request $request)
    {
        // 1) build the form
        //$creditCard = new CreditCard();
        $em = $this->getDoctrine()->getManager();
        $creditCard = $em->getRepository(CreditCard::class)->find($request->get('id'));
        $form = $this->createForm(CreditCardType::class, $creditCard);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $creditCard->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($creditCard);
            $em->flush();


            return $this->redirectToRoute('mycards');
        }

        return $this->render(
            'pages/editcarte.html.twig',
            array('form' => $form->createView())
        );


    }

    /**
     * @Route("/credit/deletecard", name="deletecard", options={"expose"=true})
     */
    public function deleteCreditCard(Request $request)
    {
        // 1) build the form
        //$creditCard = new CreditCard();
        $em = $this->getDoctrine()->getManager();
        $creditCard = $em->getRepository(CreditCard::class)->find($request->get('id'));

            $em = $this->getDoctrine()->getManager();
            $em->remove($creditCard);
            $em->flush();


            return $this->redirectToRoute('mycards');

    }

    /**
     * @Route("/credit/mycards", name="mycards")
     */
    public function mesCartes(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $cards = $em->getRepository(CreditCard::class)->findByUser($this->getUser());
        return $this->render(
            'pages/mescartes.html.twig',
            array('cartes' => $cards)
        );


    }

}
