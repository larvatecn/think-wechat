<?php
declare (strict_types=1);

namespace Larva\Wechat;

use Overtrue\Socialite\User;

class WeChatUserAuthorized
{
    public User $user;

    public bool $isNewSession;

    public string $account;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param bool $isNewSession
     * @param string $account
     */
    public function __construct(User $user, bool $isNewSession = false, string $account = '')
    {
        $this->user = $user;
        $this->isNewSession = $isNewSession;
        $this->account = $account;
    }

    /**
     * Retrieve the authorized user.
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * The name of official account.
     *
     * @return string
     */
    public function getAccount(): string
    {
        return $this->account;
    }

    /**
     * Check the user session is first created.
     *
     * @return bool
     */
    public function isNewSession(): bool
    {
        return $this->isNewSession;
    }
}