<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Service\ReturnLabelService;

/**
 * Class Confirmation
 *
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
class Confirmation implements ConfirmationInterface
{
    /**
     * @var string
     */
    private $shipmentNumber;

    /**
     * @var string
     */
    private $labelData;

    /**
     * @var string
     */
    private $qrLabelData;

    /**
     * @var string
     */
    private $routingCode;

    public function __construct(
        string $shipmentNumber,
        string $labelData,
        string $qrLabelData,
        string $routingCode
    ) {
        $this->shipmentNumber = $shipmentNumber;
        $this->labelData = $labelData;
        $this->qrLabelData = $qrLabelData;
        $this->routingCode = $routingCode;
    }

    public function getShipmentNumber(): string
    {
        return $this->shipmentNumber;
    }

    public function getLabelData(): string
    {
        return $this->labelData;
    }

    public function getQrLabelData(): string
    {
        return $this->qrLabelData;
    }

    public function getRoutingCode(): string
    {
        return $this->routingCode;
    }
}
