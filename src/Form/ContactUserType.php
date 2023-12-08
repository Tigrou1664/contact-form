<?php

namespace App\Form;

use App\Entity\ContactUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactUserType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans('form.contact.firstname'),
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans('form.contact.lastname'),
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => $this->translator->trans('form.contact.email'),
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactUser::class,
        ]);
    }
}
