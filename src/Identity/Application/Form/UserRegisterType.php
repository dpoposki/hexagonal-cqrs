<?php

namespace Poposki\Identity\Application\Form;

use Poposki\Identity\Domain\Entity\User;
use Poposki\Kernel\Application\Validator\Constraint as AppAssert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(max: 254),
                        new Assert\Email(mode: Assert\Email::VALIDATION_MODE_STRICT),
                        new AppAssert\EntityNotFound(entity: User::class, payload: ['email' => AppAssert::VALUE], message: 'This email address is already in use. Please log in instead.'),
                    ]
                ]
            )
            ->add(
                'password',
                PasswordType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\PasswordStrength(minScore: Assert\PasswordStrength::STRENGTH_MEDIUM),
                    ]
                ]
            );
    }
}
