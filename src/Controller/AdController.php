<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\User;
use App\Form\AdType;
use App\Entity\Ad;
use Symfony\Component\HttpFoundation\File\File;
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
        $picture = new Picture();
        $ad->addPicture($picture);

        $adForm = $this->createForm(AdType::class, $ad);

        $adForm->handleRequest($resquest);
        if($adForm->isSubmitted() && $adForm->isValid()) {

            $fileurl = $picture->getPath();
            
            $file->move(
                $this->getParameter('images_directory'),
                $fileurl
            );

            $em = $this->getDoctrine()->getManager();
            $ad->setDateCreated(new \DateTime());
            $ad->setMaker($this->getUser());
            $em->persist($ad);
            $em->persist($picture);

            $em->flush();

            $this->addFlash("success", "Votre annonce a bien été prise en compte !");

            //return $this->redirectToRoute('home');

        }

        return $this->render('ad/ad.html.twig', [
            "adForm" => $adForm->createView()
        ]);
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/myads", name="myads")
     */
    public function myads(Request $req) {

        $userId = $this->getUser()->getId();

        $adRepo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $adRepo->findUserAds($userId);


        return $this->render("ad/user_ad.html.twig", ["ads" => $ads]);
    }

    /**
     * @Route("/mybookmarks", name="mybookmarks")
     */
    public function mybookmarks(Request $req) {

        $userId = $this->getUser()->getId();

        $adRepo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $adRepo->findHomeAds();

        return $this->render("ad/user_bookmarks_ad.html.twig", ["ads" => $ads]);
    }


    /**
 * @Route("/addtobookmark/{id}", name="addtobookmark")
 */
    public function addtobookmark($id) {

        $user = $this->getUser();
        $adRepo = $this->getDoctrine()->getRepository(Ad::class);
        $ad = $adRepo->find($id);
        $user->addBookmark($ad);

        $em = $this->getDoctrine()->getManager();
        $em->persist($ad);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/removetobookmark/{id}", name="removetobookmark")
     */
    public function removetobookmark($id, Request $req) {

        $user = $this->getUser();
        $adRepo = $this->getDoctrine()->getRepository(Ad::class);
        $ad = $adRepo->find($id);
        $user->removeBookmark($ad);

        $em = $this->getDoctrine()->getManager();
        $em->persist($ad);
        $em->persist($user);
        $em->flush();

        $referer = $req->headers->get('referer');

        return $this->redirect($referer);

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

    /**
     * @Route("/ad/edit/{id}", name="adedit")
     */
    public function adedit(Request $resquest, $id) {

        $em = $this->getDoctrine()->getManager();
        $ad = $em->getRepository(Ad::class)->find($id);

        $adForm = $this->createForm(AdType::class, $ad);

        $adForm->handleRequest($resquest);

        if($adForm->isSubmitted() && $adForm->isValid()) {
            if (!$ad) {
                throw $this->createNotFoundException(
                    'Pas d\'annonce trouvé pour l\'id '.$id
                );
            }
            $em->flush();
            $this->addFlash("success", "Votre annonce a bien été modifiée !");

            return $this->redirectToRoute('myads');
        }

        return $this->render('ad/user_edit_ad.html.twig', [
            "adForm" => $adForm->createView(),
            "ad" => $ad
        ]);
    }

    /**
     * @Route("/ad/delete/{id}", name="addelete")
     */
    public function addelete(Request $resquest, $id) {

        $em = $this->getDoctrine()->getManager();
        $ad = $em->getRepository(Ad::class)->find($id);

        $em->remove($ad);
        $em->flush();

        $this->addFlash("success", "Votre annonce a bien été suprimée !");

        return $this->redirectToRoute('myads');

    }
}
