<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Service;

use Enbit\Dhl\Retoure\Service\ReturnLabelService\ConfirmationInterface;
use Enbit\Dhl\Retoure\Exception\AuthenticationException;
use Enbit\Dhl\Retoure\Exception\DetailedServiceException;
use Enbit\Dhl\Retoure\Service\ReturnLabelService\Confirmation;
use Enbit\Dhl\Retoure\Serializer\JsonSerializer;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzlClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ReturnLabelService
 *
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
class ReturnLabelService implements ReturnLabelServiceInterface
{
    private const OPERATION_BOOK_LABEL = 'returns/';

    /**
     * @var GuzzlClient
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var JsonSerializer
     */
    private $serializer;

    public function __construct(
        GuzzlClient $client,
        string $baseUrl,
        JsonSerializer $serializer
    ) {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->serializer = $serializer;
    }

    public function bookLabel(\JsonSerializable $returnOrder): ConfirmationInterface
    {
        $uri = sprintf('%s/%s', $this->baseUrl, self::OPERATION_BOOK_LABEL);

        try {
            $payload = $this->serializer->toArray($returnOrder);

            $response = $this->client->post($uri, ['json' => $payload]);
            $responseJson = (string) $response->getBody();
        }catch (RequestException $exception) {
            if($exception->hasResponse()){
                $response = $exception->getResponse();
                $statusCode = $response->getStatusCode();
                if($this->isDetailedErrorResponse($response)) {
                    $responseJson = (string)$response->getBody();
                    $responseData = $this->serializer->decode($responseJson);
                    $errorMessage = $this->createErrorMessage($responseData, $response->getReasonPhrase());
                }else{
                    $errorMessage = ($statusCode === 401 || $statusCode === 403)?
                        'Authentication failed. Please check your access credentials.' :
                        $response->getReasonPhrase();
                }

                if ($statusCode === 401 || $statusCode === 403) {
                    throw new AuthenticationException($errorMessage, $exception->getCode(), $exception);
                }
                if ($statusCode >= 400 && $statusCode < 600) {
                    throw new DetailedServiceException($errorMessage, $exception->getCode(), $exception);
                }
            }
            throw $exception;
        }

        $responseData = $this->serializer->decode($responseJson);

        $shipmentNumber = $responseData['shipmentNumber'] ?: '';
        $labelData = $responseData['labelData'] ?: '';
        $qrLabelData = $responseData['qrLabelData'] ?: '';
        $routingCode = $responseData['routingCode'] ?: '';

        return new Confirmation($shipmentNumber, $labelData, $qrLabelData, $routingCode);
    }

    /**
     * Returns TRUE if the response contains a detailed error response.
     *
     * @param ResponseInterface $response
     *
     * @return bool
     */
    private function isDetailedErrorResponse(ResponseInterface $response): bool
    {
        $contentTypes = $response->getHeader('Content-Type');
        return $contentTypes && ($contentTypes[0] === 'application/json');
    }

    /**
     * Try to extract the error message from the response. If not possible, return default message.
     *
     * @param string[] $responseData
     * @param string $defaultMessage
     * @return string
     */
    private function createErrorMessage(array $responseData, string $defaultMessage): string
    {
        if (isset($responseData['statusCode'], $responseData['statusText'])) {
            return sprintf('%s (Error %s)', $responseData['statusText'], $responseData['statusCode']);
        }
        if (isset($responseData['code'], $responseData['detail'])) {
            return sprintf('%s (Error %s)', $responseData['detail'], $responseData['code']);
        }
        return $defaultMessage;
    }
}
