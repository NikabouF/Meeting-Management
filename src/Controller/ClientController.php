<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(MeetingRepository $meetingRepository, UserRepository $userRepository)
    {
        $user = $this->getUser();
        $meetings = $userRepository->findMeeting($user->getId(), new \DateTime('now'));
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'meetings' => $meetings
        ]);
    }
    /**
     * @Route("/check/{id}", name="check")
     */
    public function check(Request $request, $id, UserRepository $userRepository, MeetingRepository $meetingRepository)
    {
        $m = $meetingRepository->findOneBy([
            'id' => $id
        ]);
        $time = new \DateTime('now');
        return new JsonResponse(1);
    }
}
