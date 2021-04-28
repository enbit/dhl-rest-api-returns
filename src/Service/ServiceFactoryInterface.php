<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Service;

/**
 * Interface ServiceFactoryInterface
 *
 * @api
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
interface ServiceFactoryInterface
{
    public const BASE_URL_PRODUCTION = 'https://cig.dhl.de/services/production/rest';
    public const BASE_URL_SANDBOX = 'https://cig.dhl.de/services/sandbox/rest';

    /**
     * Create the service able to perform return shipment label requests.
     *
     * @return ReturnLabelServiceInterface
     *
     * @throws \Exception
     */
    public function createReturnLabelService(): ReturnLabelServiceInterface;
}
