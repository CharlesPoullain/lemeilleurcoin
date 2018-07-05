<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PictureController extends Controller
{
    /**
     * @Route("/picture", name="picture")
     */
    public function index(Request $request)
    {
        $picture = new Picture();


    }
}
