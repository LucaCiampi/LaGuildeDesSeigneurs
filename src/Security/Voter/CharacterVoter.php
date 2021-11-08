<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_DISPLAY = 'characterDisplay';

    private const ATTRIBUTES = array(
        self::CHARACTER_CREATE,
        self::CHARACTER_DISPLAY,
    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }

        return in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * 
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // Defines access rights
        switch ($attribute) {
            case self::CHARACTER_CREATE:
                // Peut envoyer $token et $subject pour tester les conditions
                return $this->canCreate(); //$this->canDisplay($token, $subject)
                break;
            case self::CHARACTER_DISPLAY:
                // Peut envoyer $token et $subject pour tester les conditions
                return $this->canDisplay(); //$this->canDisplay($token, $subject)
                break;
        }
        throw new LogicException('Invalid attribute : ' . $attribute);
    }

    /**
     * Checks if is allowed to display
     * @return bool
     */
    public function canDisplay(): bool
    {
        return true;
    }

    /**
     * Checks if is allowed to create
     * @return bool
     */
    public function canCreate(): bool
    {
        return true;
    }
}
