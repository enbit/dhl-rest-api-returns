<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Auth;

/**
 * Class AuthenticationStorage
 *
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
class AuthenticationStorage implements AuthenticationStorageInterface
{
    /**
     * @var string
     */
    private $applicationId;

    /**
     * @var string
     */
    private $applicationToken;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $signature;

    public function __construct(
        string $applicationId,
        string $applicationToken,
        string $user,
        string $signature
    ) {
        $this->applicationId = $applicationId;
        $this->applicationToken = $applicationToken;
        $this->user = $user;
        $this->signature = $signature;
    }

    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    public function getApplicationToken(): string
    {
        return $this->applicationToken;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
