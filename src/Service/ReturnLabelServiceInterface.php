<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Service;

use Enbit\Dhl\Retoure\Service\ReturnLabelService\ConfirmationInterface;
use Enbit\Dhl\Retoure\Exception\AuthenticationException;
use Enbit\Dhl\Retoure\Exception\DetailedServiceException;
use GuzzleHttp\Exception\RequestException;

/**
 * Interface ReturnLabelServiceInterface
 *
 * @api
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
interface ReturnLabelServiceInterface
{
    /**
     * BookLabel is the operation call used to generate return labels.
     *
     * @param \JsonSerializable $returnOrder
     *
     * @return ConfirmationInterface
     *
     * @throws AuthenticationException
     * @throws DetailedServiceException
     * @throws RequestException
     */
    public function bookLabel(\JsonSerializable $returnOrder): ConfirmationInterface;
}
