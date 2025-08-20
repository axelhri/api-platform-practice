<?php

namespace App\Security\Voter;

use App\Entity\Folk;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class FolkVoter extends Voter
{

    public const EDIT = 'FOLK_EDIT';
    public const DELETE = 'FOLK_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE], true) && $subject instanceof Folk;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof Folk) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return true;
        }

        if ($subject->getUser()->getId() === $user->getId()) {
            return true;
        }

        return false;
    }
}
