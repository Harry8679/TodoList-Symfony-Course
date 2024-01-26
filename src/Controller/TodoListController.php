<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    private $entityManager;
    
    private $taskRepository;

    public function __construct(EntityManagerInterface $entityManager, TaskRepository $taskRepository)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }

    #[Route('/', name: 'app_todo_list')]
    public function index(): Response
    {
        $tasks = $this->taskRepository->findAll();
        // dd($tasks);

        return $this->render('todo_list/index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    #[Route('/creer', name: 'app_create_task')]
    public function create(Request $request): Response
    {
        $title = trim($request->request->get('title'));

        if (empty($title)) {
            return $this->redirectToRoute('app_todo_list');
        }

        $task = new Task();
        $task->setTitle($title)
             ->setStatus(false);
        
        // dd($task);
        // $task->setTitle($title);
        // $task->setStatus(false);
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_todo_list');
    }

    #[Route('/switch-status/{id}', name: 'app_switch_status')]
    public function switchStatus($id)
    {
        $task = $this->taskRepository->find($id);
        $task->setStatus(!$task->isStatus());
        $this->entityManager->flush();
        
        return $this->redirectToRoute('app_todo_list');
    }

    #[Route('/delete/{id}', name: 'app_delete_task')]
    public function delete($id)
    {
        $task = $this->taskRepository->find($id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_todo_list');
    }
}
