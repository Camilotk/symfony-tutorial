<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createFormBuilder()
            ->add('username', null, [
                'attr' => [
                    'class' => 'input is-primary'
                ],
                'row_attr' => [
                    'class' => 'field'
                ],
                'label_attr' => [
                    'class' => 'label'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'input is-primary'
                    ],
                    'row_attr' => [
                        'class' => 'field'
                    ],
                    'label_attr' => [
                        'class' => 'label'
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'class' => 'input is-primary'
                    ],
                    'row_attr' => [
                        'class' => 'field'
                    ],
                    'label_attr' => [
                        'class' => 'label'
                    ]
                ],

            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'button is-primary'
                ]
            ])
            ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // pega os dados do formulário
            $data = $form->getData();

            // cria o objeto User a ser persistido
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword($encoder->encodePassword($user, $data['password']));

            // persist the data
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView()
        ]);
    }
}
