<?php

namespace App\Security\Voter;

use App\Entity\BlogPost;
use App\Entity\Folk;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends Voter<string, BlogPost>
 */
final class BlogPostVoter extends Voter
{
    public const EDIT = 'BLOGPOST_EDIT';
    public const DELETE = 'BLOGPOST_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE]) && $subject instanceof BlogPost;
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

        if ($subject->getAuthor()?->getId() === $user->getId()) {
            return true;
        }

        return false;
    }
}
