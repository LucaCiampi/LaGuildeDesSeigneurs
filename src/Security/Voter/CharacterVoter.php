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
    public const CHARACTER_INDEX = 'characterIndex';
    public const CHARACTER_MODIFY= 'characterModify';
    public const CHARACTER_DELETE= 'characterDelete';

    private const ATTRIBUTES = array(
        self::CHARACTER_CREATE,
        self::CHARACTER_DISPLAY,
        self::CHARACTER_INDEX,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE,
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
            case self::CHARACTER_DISPLAY:
            case self::CHARACTER_INDEX:
                // Peut envoyer $token et $subject pour tester les conditions
                return $this->canDisplay(); //$this->canDisplay($token, $subject)
            case self::CHARACTER_MODIFY:
                return $this->canModify();
            case self::CHARACTER_DELETE:
                return $this->canDelete();
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

    /**
     * Checks if is allowed to modify
     * @return bool
     */
    public function canModify(): bool
    {
        return true;
    }

    /**
     * Checks if is allowed to delete
     * @return bool
     */
    public function canDelete(): bool
    {
        return true;
    }
}
