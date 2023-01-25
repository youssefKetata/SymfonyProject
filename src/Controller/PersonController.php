<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('person')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'person.list')]
    public function index(ManagerRegistry $doctrine):Response{
        $repository=$doctrine->getRepository(Person::class);
        $persons=$repository->findAll();
        return $this->render('person/index.html.twig',[
            'persons'=>$persons
        ]);

    }

    #[Route('/all/age/{minAge}/{maxAge}', name: 'person.list.age')]
    public function personByAge(ManagerRegistry $doctrine, $minAge, $maxAge):Response{
        $repository=$doctrine->getRepository(Person::class);
        $persons=$repository->findPersonByAgeInterval($minAge, $maxAge);
        return $this->render('person/index.html.twig',[
            'persons'=>$persons
        ]);
    }

    #[Route('/all/statAge/{minAge}/{maxAge}', name: 'person.list.statAge')]
    public function personStatByAge(ManagerRegistry $doctrine, $minAge, $maxAge):Response{
        $repository=$doctrine->getRepository(Person::class);
        $stat=$repository->statByAgeInterval($minAge, $maxAge);
        return $this->render('person/stat.html.twig',[
            'stat'=>$stat[0]
        ]);
    }

    #[Route('/delete/{id}', name: 'person.delete')]
    public function deletePerson(ManagerRegistry $doctrine,Person $person=null): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if($person){
            $manager=$doctrine->getManager();
            $manager->remove($person);
            $manager->flush();
            $this->addFlash('success', 'person was deleted from database');
        }else{
            $this->addFlash('error','this person does not exist');
        }
        return $this->redirectToRoute('person.list.all');
    }

    #[Route('/edit/{id}/{firstname}/{name}/{age}', name: 'person.edit')]
    public function editPerson(ManagerRegistry $doctrine, $firstname, $name, $age,Person $person=null): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if($person){
            $entityManager=$doctrine->getManager();
            $O_firstname=$person->getFirstname();
            $O_name=$person->getname();
            $O_age=$person->getage();

            $person->setFirstname($firstname);
            $person->setname($name);
            $person->setAge($age);

            $entityManager->persist($person);
            $entityManager->flush();
            $this->addFlash('success','person information was updated');
        }else{
            $this->addFlash('error','Can not edit, this person does not exist');
        }
        return $this->redirectToRoute('person.list.all');
    }

    #[Route('/all/{page?1}/{number?9}', name: 'person.list.all')]
    public function indexAll(ManagerRegistry $doctrine, $page, $number):Response{
        $repository=$doctrine->getRepository(Person::class);
        $persons=$repository->findBy([],limit: $number, offset: ($page-1)*9 );
        $nbPages=(int)ceil($repository->count([])/$number);
        return $this->render('person/index.html.twig',[
            'persons'=>$persons,
            'isPaginated'=>true,
            'nbPages'=>$nbPages,
            'page'=>$page,
            'number'=>$number
        ]);

    }

    #[Route('/{id<\d+>}', name: 'person.detail')]
    public function detail(Person $person=null):Response{
        if(!$person){
            $this->addFlash('error', "this person does not exist");
            return $this->redirectToRoute('person.list');
        }
        return $this->render('person/detail.html.twig',[
            'person'=>$person
        ]);

    }
    #[Route('/edit/{id?0}', name: 'person.edit')]
    public function addPerson(ManagerRegistry $doctrine, Request $request, Person $person=null, SluggerInterface $slugger): Response
    {
        $new=false;
        if(!$person){
            $new=true;
            //add(if id was not taped id=0 ->$person doesn't exist)
            $person = new Person();
        }
        //edit(if id was  taped id!=0 ->$person exist
        //$person est l'image de notre fomrulaire
        $form = $this->createForm(PersonType::class, $person);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        //mon fomrulaire va allez trairez la requete
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            //handle photo upload
            $photo = $form->get('photo')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('person_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $person->setImage($newFilename);
            }

            //verif la donnes to do
            $manager=$doctrine->getManager();
            $manager->persist($person);
            $manager->flush();
            if($new){
                $message='Welcome ' . $person->getName() .
                    " ,thank you for signing up, you're account was create successfully";
            }else{
                $message= $person->getName() . ' was edited successfully';
            }
            $this->addFlash('success', $message);
            return $this->redirectToRoute('person.list.all');
        }else{
            return $this->render('person/add-person.html.twig', [
                'form'=>$form->createView()
            ]);
        }
    }
}
