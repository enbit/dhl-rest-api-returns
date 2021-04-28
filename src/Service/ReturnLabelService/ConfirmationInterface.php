<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Service\ReturnLabelService;

/**
 * Interface ConfirmationInterface
 *
 * @api
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
interface ConfirmationInterface
{
    /**
     * Obtain the shipment number of the created return label.
     *
     * @return string
     */
    public function getShipmentNumber(): string;

    /**
     * Obtain the base64 encoded label PDF binary.
     *
     * @return string
     */
    public function getLabelData(): string;

    /**
     * Obtain the base64 encoded QR code PNG binary.
     *
     * @return string
     */
    public function getQrLabelData(): string;

    /**
     * Obtain the routing code of the created return label.
     *
     * @return string
     */
    public function getRoutingCode(): string;
}
