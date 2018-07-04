<?php

namespace App\Controller;

use App\Form\AdType;
use App\Entity\Ad;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdController extends Controller
{

    public function ad()
    {
        return $this->render('ad/ad.html.twig', []);
    }

    /**
     * @Route("/ad", name="ad")
     */
    public function adCreate(Request $resquest) {
        $ad = new Ad();
        $adForm = $this->createForm(AdType::class, $ad);

        $adForm->handleRequest($resquest);
        if($adForm->isSubmitted() && $adForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ad->setDateCreated(new \DateTime());

            $em->persist($ad);
            $em->flush();

            $this->addFlash("success", "Votre annonce à bien été prise en compte !");

            return $this->redirectToRoute('home');

        }

        return $this->render('ad/ad.html.twig', [
            "adForm" => $adForm->createView()
        ]);
    }

    /**
     * @Route("/ad/detail/{id}", name="detail", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function detail(Ad $item) {

        /*
        $adRepo = $this->getDoctrine()->getRepository(Ad::class );
        $item = $adRepo->find($id);
        */

        return $this->render('ad/addisplay.html.twig', [
            "item" => $item
        ]);
    }
}
