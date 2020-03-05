<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\Invite;
use App\Form\FollowType;
use App\Form\GroupeType;
use App\Form\InviteType;
use App\Entity\Eventuser;
use App\Form\AccountType;
use App\Form\UsereventType;
use App\Form\AccountimgType;
use App\Repository\UserRepository;
use App\Repository\GroupeRepository;
use App\Repository\InviteRepository;
use App\Repository\EventuserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MyspaceController extends AbstractController
{
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/myspace", name="myspace")
     */
    public function index(Request $request, GroupeRepository $grprepo, InviteRepository $invite, UserPasswordEncoderInterface $encoder, Userrepository $userrepo)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $users = $userrepo->findAll();
        $invites = $user->getInvites();

        $arr2 = [];
        foreach($invites as $in){
            $inId = $in->getId();
            $gr = $in->getGroupe();
            $u = $in->getUsers();
            foreach($gr as $g)
            {
             $gId = $g->getId();
            }
            foreach($u as $us)
            {
             $uId = $us->getId();
            }
            $formbuild = $this->get('form.factory')->createNamedBuilder($inId, InviteType::class, $user)
            ->add('user', HiddenType::class, [
                'attr' => ['value' => $uId],
                'mapped' => false,
            ])
            ->add('groupe', HiddenType::class, [
                'attr' => ['value' => $gId],
                'mapped' => false,
            ])
            ->getForm();
            $forms = $formbuild->createView();
            $arr2[] = $forms;

            $arr3[] = $formbuild->handleRequest($request);
           foreach($arr3 as $f){
            if($request->isXmlHttpRequest()){

                $dg = $request->request->get('idg');
                $du = $request->request->get('idu');
                $gid = $grprepo->find($dg);
                $uid = $userrepo->find($du);
                $a = $uid->addGrp($gid);

                $n = $gid->getName();
                $img = $gid->getImage();
                $idg = $gid->getId();

                $entityManager->flush();

                 return New JsonResponse(['name' => $n, 'img' => $img, 'id' => $idg]);
            }
           }
          }

        $form = $this->createForm(AccountType:: class, $user);
        $form->handleRequest($request);

        $groupe = new Groupe();
        $formGrp = $this->createForm(GroupeType::class, $groupe);
        $formGrp->handleRequest($request);

        $userevent = new Eventuser();
        $formEventUser = $this->createForm(UsereventType::class, $userevent);
        $formEventUser->handleRequest($request);

        $formImgUpdate = $this->createForm(AccountimgType::class, $user);
        $formImgUpdate->handleRequest($request);

        if($formImgUpdate->isSubmitted() && $formImgUpdate->isValid()){
            $image = $formImgUpdate->get('avatar')->getData();
            if(!empty($image)) {
            $name = $user->getId().''.mt_rand(0,1000000);
            $imageName = $name.'.'. $image->guessExtension();
            $image->move(
                $this->getParameter('image_directory'),
                $imageName
            );
            $user->setAvatar($imageName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('myspace');
        }

        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute("index");
        }

        if($formGrp->isSubmitted() && $formGrp->isValid()){

            $groupe->setUser($user);

            $image = $formGrp->get('image')->getData();
            if(!empty($image)) {
            $name = $groupe->getId().''.mt_rand(0,1000000);
            $imageName = $name.'.'. $image->guessExtension();
            $image->move(
                $this->getParameter('image_directory'),
                $imageName
            );
            $groupe->setImage($imageName);
        }
        else {
            $groupe->setImage('default.png');
        }

            $entityManager->persist($groupe);
            $entityManager->flush();

            return $this->redirectToRoute('myspace');
        }

        if($formEventUser->isSubmitted() && $formEventUser->isValid()){

            $userevent->setUser($user);

            $entityManager->persist($userevent);
            $entityManager->flush();

            return $this->redirectToRoute('myspace');
        }

        return $this->render('myspace/index.html.twig', [
            'accountForm' => $form->createView(),
            'user' => $user,
            'users' => $users,
            'formGroupe' => $formGrp->createView(),
            'formUserevent' => $formEventUser->createView(),
            'formImgUpdate' => $formImgUpdate->createView(),
            'forms' => $arr2,
            ]);
    }

    /**
     * @Route("/myspace/{id}", name="myspaceuser")
     */
    public function indexUser($id, UserRepository $userrep, User $userentity, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $grp = $userentity->getGroupe();
        $event = $userentity->getEvuser();
        $user = $this->getUser();
        $users = $userrep->findAll();
        $userid = $userrep->find($id);

        $form = $this->createForm(FollowType:: class, $user);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()){

            $user->addFriend($userid);
            $data = $userid->getId();

            $entityManager->flush();
           
            return New JsonResponse(['data' => $data]);

        }

        return $this->render('myspace/index.html.twig', [
            'users' => $users,
            'groupe' => $grp,
            'user' => $userid,
            'userevs' => $event,
            'followForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/myspace/{id}/deletegroupe", name="deletegrpuser")
     */
    public function deleteGrp($id, Groupe $groupe){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($groupe);
        $entityManager->flush();
        
        return $this->redirectToRoute('myspace');
     }

     /**
     * @Route("/myspace/{id}/deleteevent", name="deleteeventuser")
     */
    public function deleteEvent($id, Eventuser $event){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($event);
        $entityManager->flush();
        
        return $this->redirectToRoute('myspace');
     }

     /**
     * @Route("myspace/{id}/deleteallevent", name="deleteallev")
     */
    public function deleteAllevent($id, Userrepository $userrepos){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $user = $userrepos->find($id);
        $ev = $user->getEvuser();
        foreach( $ev as $e){
            $entityManager->remove($e);
            $entityManager->flush();
        }

        return $this->redirectToRoute('myspace');

      }

    /**
     * @Route("myspace/{id}/unfollow", name="unfollow")
     */

     public function unfollow(UserRepository $repo, $id){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

        $userId = $repo->find($id);
        $user = $this->getUser();
        $a = $user->getFriends();
        foreach($a as $k){
         if($k == $userId){
            $user->removeFriend($k);
        }
    }
        $entityManager->flush();

        return New JsonResponse();

     }

     /**
      * @Route("myspace/{id}/deleteinvite", name="deleteinvite")
      */

      public function deleteInvite($id, InviteRepository $irepo){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

         $in = $irepo->find($id);
         $user = $this->getUser();
         $a = $in->getUsers();

         foreach($a as $k){
             if($user === $k){
                $in->removeUser($k);
                 }
                }

         $entityManager->flush();

          return New JsonResponse();

      }

     /**
      * @Route("myspace/{id}/deleteins", name="deleteins")
      */

      public function deleteIns($id, InviteRepository $irepo){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $this->getDoctrine()->getManager();

         $in = $irepo->find($id);
         $user = $this->getUser();
         $a = $in->getUsers();
         $gs = $in->getGroupe();
         $gus = $user->getGrps();

         if(!empty($gus)){
            foreach($gus as $t){
                $usg = $t->getUsers();
                $usg;
                foreach($usg as $usersg){
                    $usersg;
                }
            if($usersg === $user){
              $in->removeUser($user);
            }
            else{
               dump('error');
            }
           }
          }

         $entityManager->flush();

          return New JsonResponse();

      }
}