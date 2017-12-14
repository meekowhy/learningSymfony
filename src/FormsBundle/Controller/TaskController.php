<?php

namespace FormsBundle\Controller;

use FormsBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FormsBundle\Entity\Tag;
use FormsBundle\Form\TaskType;

/**
 * Task controller.
 *
 * @Route("task")
 */
class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/")
     */
    public function newAction(Request $request)
    {
        $task = new Task();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
//        $tag1 = new Tag();
//        $tag1->setName('tag1');
//        $task->getTags()->add($tag1);
//        $tag2 = new Tag();
//        $tag2->setName('tag2');
//        $task->getTags()->add($tag2);
        // end dummy code

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... maybe do some form processing, like saving the Task and Tag objects
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

        }

        return $this->render('FormsBundle:Task:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
