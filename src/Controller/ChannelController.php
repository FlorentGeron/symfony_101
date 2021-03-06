<?php

namespace App\Controller;

use App\Entity\Channel;
use App\Form\ChannelType;
use App\Repository\ChannelRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/channel')]
class ChannelController extends AbstractController
{
    #[Route('/index', name: 'app_channel_index', methods: ['GET'])]
    public function index(ChannelRepository $channelRepository): Response
    {
        return $this->render('channel/index.html.twig', [
            'channels' => $channelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_channel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChannelRepository $channelRepository): Response
    {
        $channel = new Channel();
        $form = $this->createForm(ChannelType::class, $channel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          //dd($form->getData());
          $channelRepository->add($channel, true);

            return $this->redirectToRoute('app_channel_show', ['id' => $channel->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('channel/new.html.twig', [
            'channel' => $channel,
            'form' => $form,
        ]);
    }

    #[Route('/newpm/{user_id}', name: 'app_channel_newpm', methods: ['GET', 'POST'])]
    public function newpm(ChannelRepository $channelRepository, int $user_id, UserRepository $userRepository): Response
    {
        $channel = new Channel();
        $invitee = $userRepository->find($user_id);
        $user = $this->getUser();
        $channel->addUser($user);
        $channel->addUser($invitee);
        $channel->setTitle("PM {$user} - {$invitee}");
        $channelRepository->add($channel, true);

        return $this->redirectToRoute('app_channel_show', ['id' => $channel->getId()], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id?1}', name: 'app_channel_show', methods: ['GET', 'POST'])]
    public function show(Request $request, MessageRepository $messageRepository, Channel $channel, ChannelRepository $channelRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $message = new Message();
        $message->setCreatedAt(new \DateTime('now'));
        $message->setChannelId($channel);
        $message->setOwner($user);
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $messageRepository->add($message, true);

          return $this->render('message/_newmsg.html.twig', [
            'message' => $message,
        ]);

        // return $this->redirectToRoute('app_channel_show', ['id' => $channel->getId()], Response::HTTP_SEE_OTHER);
      }

        return $this->renderForm('channel/show.html.twig', [
            'channel' => $channel,
            'messages' => $channel->getMessages(),
            'channels' => $channelRepository->findbyUser($user),
            'users' => $userRepository->findAllExcept($user),
            'form' => $form,
            'client' => $user,
        ]);
    }


    #[Route('/{id}', name: 'app_channel_delete', methods: ['POST'])]
    public function delete(Request $request, Channel $channel, ChannelRepository $channelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$channel->getId(), $request->request->get('_token'))) {
            $channelRepository->remove($channel, true);
        }

        return $this->redirectToRoute('app_channel_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_channel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Channel $channel, ChannelRepository $channelRepository): Response
    {
        $form = $this->createForm(ChannelType::class, $channel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $channelRepository->add($channel, true);

            return $this->redirectToRoute('app_channel_show', ['id' => $channel->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('channel/edit.html.twig', [
            'channel' => $channel,
            'form' => $form,
        ]);
    }
}
