<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Auth;

/**
 * Interface AuthenticationStorageInterface
 *
 * @api
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
interface AuthenticationStorageInterface
{
    public function getApplicationId(): string;

    public function getApplicationToken(): string;

    public function getUser(): string;

    public function getSignature(): string;
}
