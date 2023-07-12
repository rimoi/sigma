<?php

namespace App\Controller\BackOffice;

use App\Constant\UserConstant;
use App\Entity\File;
use App\Entity\User;
use App\Form\ProfileClientFormType;
use App\Form\ProfileFormType;
use App\helper\ArrayHelper;
use App\helper\FormHelper;
use App\Security\UsersAuthenticator;
use App\Service\FileUploader;
use App\Service\QualificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/admin', name: 'admin_profile_')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'index')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        QualificationService $qualificationService,
        UserAuthenticatorInterface $userAuthenticator,
        UsersAuthenticator $authenticator
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();


        $userAuthenticator->authenticateUser(
            $user,
            $authenticator,
            $request
        );

        $form = $this->createForm(ProfileFormType::class, $user, ['show_experience' => true]);
        $form->handleRequest($request);

        $errors = null;

        if ($form->isSubmitted() && $form->isValid()) {

                $qualificationService->addElement($form, 'cni');
                $qualificationService->addElement($form, 'permisConduite');
                $qualificationService->addElement($form, 'criminalRecord');
                $qualificationService->addElement($form, 'iban');
                $qualificationService->addElement($form, 'autoentrepriseCertificate');

                // Decommenter quand on rajout le CV
                //$qualificationService->addElement($form, 'file');

                $qualificationService->addExperience($form, 'qualifications');

            $entityManager->flush();

            $this->addFlash('success', 'Les modifications ont bien été enregistrées !');

            return $this->redirectToRoute('admin_dash_board_index');
        } elseif ($form->isSubmitted() && !$form->isValid()) {

            $errors = FormHelper::getErrorsFromForm($form, true);

        }

        $params = [
            'form' => $form,
            'errors' => $errors,
            'show_updaded_image' => !!$errors,
        ];

            return $this->renderForm('back_office/profile/profil_client.html.twig', $params);
    }
}
