<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RapportController extends AbstractController
{
    /**
     * @Route("/rapport", name="rapport")
     */
    public function index(MeetingRepository $meetingRepository)
    {
        $p = $meetingRepository->findPart(new \DateTime('now'), 3);
        $date = new \DateTime();
        dump($p);
        $meeting = $meetingRepository->findMeetingPast($date);
        $meeting1 = $meetingRepository->findMeetingToday($date);
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
            'meetings' => $meeting,
            'meeting' => $meeting1,
            'participants' => $p
        ]);
    }

    /**
     * @Route("/search/{id}", name="search")
     */
    public function search(MeetingRepository $meetingRepository, $id)
    {
        $p = $meetingRepository->findPart(new \DateTime('now'), $id);
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
            'participants' => $p
        ]);
    }
}
