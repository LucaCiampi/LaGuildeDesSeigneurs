<?php

namespace App\Security\Voter;

use App\Entity\Player;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PlayerVoter extends Voter
{
    public const PLAYER_CREATE = 'playerCreate';
    public const PLAYER_DISPLAY = 'playerDisplay';
    public const PLAYER_INDEX = 'playerIndex';
    public const PLAYER_MODIFY= 'playerModify';
    public const PLAYER_DELETE= 'playerDelete';

    private const ATTRIBUTES = array(
        self::PLAYER_CREATE,
        self::PLAYER_DISPLAY,
        self::PLAYER_INDEX,
        self::PLAYER_MODIFY,
        self::PLAYER_DELETE,
    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Player && in_array($attribute, self::ATTRIBUTES);
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
            case self::PLAYER_CREATE:
                // Peut envoyer $token et $subject pour tester les conditions
                return $this->canCreate(); //$this->canDisplay($token, $subject)
                break;
            case self::PLAYER_DISPLAY:
            case self::PLAYER_INDEX:
                // Peut envoyer $token et $subject pour tester les conditions
                return $this->canDisplay(); //$this->canDisplay($token, $subject)
                break;
            case self::PLAYER_MODIFY:
                return $this->canModify();
                break;
            case self::PLAYER_DELETE:
                return $this->canDelete();
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
