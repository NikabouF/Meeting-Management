<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\UserRepository;
use App\Repository\MeetingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReunionController extends AbstractController
{
    /**
     * @Route("/reunion/{id}", name="take")
     */
    public function search(MeetingRepository $meetingRepository, $id, UserRepository $userRepository)
    {
        $p = $meetingRepository->findP($id);
        $m = $meetingRepository->findOneBy(
            [
                'id' => $id
            ]
        );
        return $this->render('reunion/participants.html.twig', [
            'participants' => $p,
            'm' => $m
        ]);
    }

    /**
     * @Route("/reunion", name="reunion")
     */
    public function index(Request $request, MeetingRepository $meetingRepository, UserRepository $userRepository)
    {
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $d = $request->request->get('date');
            $date = \DateTime::createFromFormat('d-m-Y', $d);
            $ser = $request->request->get('select');
            dump($ser);
            foreach ($ser as $se) {
                $services = $this->getDoctrine()->getRepository(User::class)->findOneBy(
                    ['id' => $se]
                );
                $meeting->addUser($services);
            }
            $meeting->setDate($date);
            $entityManager->persist($meeting);
            $entityManager->flush();
            $this->addFlash('success', "Enregistrement effectue avec succes");
            return $this->redirectToRoute('reunion');
        }
        return $this->render('reunion/index.html.twig', [
            'controller_name' => 'ReunionController',
            'form' => $form->createView(),
            'meetings' => $meetingRepository->findLast(),
            'participants' => $userRepository->findParticipants(),
        ]);
    }
}
