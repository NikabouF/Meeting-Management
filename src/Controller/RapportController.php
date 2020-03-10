<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Repository\MeetingRepository;
use App\Repository\UserRepository;
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
        $date = new \DateTime();
        $meeting = $meetingRepository->findMeetingPast($date);
        $meeting1 = $meetingRepository->findMeetingToday($date);
        return $this->render('rapport/index.html.twig', [
            'controller_name' => 'RapportController',
            'meetings' => $meeting,
            'meeting' => $meeting1,
        ]);
    }

    /**
     * @Route("/rapport/{id}", name="presence")
     */
    public function search(MeetingRepository $meetingRepository, $id, UserRepository $userRepository)
    {
        $p = $meetingRepository->findParticipants($id);
        $m = $meetingRepository->findOneBy(
            [
                'id' => $id
            ]
        );
        return $this->render('rapport/presences.html.twig', [
            'controller_name' => 'RapportController',
            'participants' => $p,
            'm' => $m
        ]);
    }
}
