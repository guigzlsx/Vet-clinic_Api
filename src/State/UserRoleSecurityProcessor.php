<?php

namespace App\State;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRoleSecurityProcessor implements ProcessorInterface
{
    private ProcessorInterface $decorated;
    private Security $security;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        ProcessorInterface $decorated,
        Security $security,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->decorated = $decorated;
        $this->security = $security;
        $this->passwordHasher = $passwordHasher;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // Si c'est un utilisateur
        if ($data instanceof User) {
            // Vérifier les rôles demandés lors de la création
            if (empty($data->getId())) { // création (pas d'ID encore)
                $requestedRoles = $data->getRoles();
                
                // Si on essaie de créer un ASSISTANT ou VETERINAIRE sans être DIRECTOR
                if ((in_array('ROLE_ASSISTANT', $requestedRoles) || in_array('ROLE_VETERINAIRE', $requestedRoles) || in_array('ROLE_DIRECTOR', $requestedRoles)) 
                    && !$this->security->isGranted('ROLE_DIRECTOR')) {
                    throw new AccessDeniedException('Only directors can create assistant, veterinarian or director accounts.');
                }
            }

            // Hachage du mot de passe s'il est présent
            $plainPassword = $data->getPlainPassword();
            if ($plainPassword) {
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $data,
                    $plainPassword
                );
                $data->setPassword($hashedPassword);
                $data->eraseCredentials();
            }
        }

        // Continuer le traitement normal
        return $this->decorated->process($data, $operation, $uriVariables, $context);
    }
}