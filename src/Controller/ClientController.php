<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/check/{id}/{part}", name="check")
     */
    public function check(Request $request, $id, $part, UserRepository $userRepository, MeetingRepository $meetingRepository)
    {
        $user = $this->getUser();
        $date = new \DateTime('now');
        $in = $meetingRepository->findIn($id, $date);
        $before = $meetingRepository->findbefore($id, $date);
        $after = $meetingRepository->findafter($id, $date);
        $m = $meetingRepository->findOneBy([
            'id' => $id
        ]);
        $p = $userRepository->findOneBy([
            'id' => $part
        ]);
        $entityManager = $this->getDoctrine()->getManager();
        if ($before) {
            $this->addFlash('error', 'Désolé la réunion n\'a pas encore commencé');
            return $this->redirectToRoute('client');
        }
        if ($after) {
            $this->addFlash('error', 'Désolé la réunion est finie');
            return $this->redirectToRoute('client');
        }
        if ($in) {
            $m->setPresent(true);
            $p->setPresent(true);
            $entityManager->persist($m);
            $entityManager->persist($p);
            $entityManager->flush();
            $this->addFlash('success', 'Merci pour votre confirmation');
            return $this->redirectToRoute('client');
        }
        return new Response();
    }
}
