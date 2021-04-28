<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Service;

use Enbit\Dhl\Retoure\Auth\AuthenticationStorageInterface;
use Enbit\Dhl\Retoure\Serializer\JsonSerializer;
use GuzzleHttp\Client as GuzzlClient;

/**
 * Class ServiceFactory
 *
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://www.enbit.de/
 */
class ServiceFactory implements ServiceFactoryInterface
{
    /**
     * @var AuthenticationStorageInterface
     */
    private $authStorage;
    /**
     * @var bool
     */
    private $sandboxMode;
    /**
     * @var GuzzlClient
     */
    private $client;

    public function __construct(
        AuthenticationStorageInterface $authStorage,
        bool $sandboxMode = false
    )
    {
        $this->authStorage = $authStorage;
        $this->sandboxMode = $sandboxMode;
        $this->client = $this->createClient();
    }

    public function createReturnLabelService(): ReturnLabelServiceInterface
    {
        return new ReturnLabelService(
            $this->client,
            $this->sandboxMode ? self::BASE_URL_SANDBOX : self::BASE_URL_PRODUCTION,
            new JsonSerializer()
        );
    }

    private function createClient()
    {
        $userAuth = base64_encode($this->authStorage->getUser() . ':' . $this->authStorage->getSignature());
        $headers = [
            'DPDHL-User-Authentication-Token' => $userAuth,
            'accept'    =>  'application/json',
            'Accept-Encoding'   => 'gzip, deflate, br',
        ];


        $uri = $this->sandboxMode ? self::BASE_URL_SANDBOX : self::BASE_URL_PRODUCTION;

        $client = new GuzzlClient([
            'base_uri'      =>      $uri,
            'auth'          =>      [$this->authStorage->getApplicationId(), $this->authStorage->getApplicationToken()],
            'headers'       =>      $headers,
        ]);

        return $client;
    }

    /**
     * @return AuthenticationStorageInterface
     */
    public function getAuthStorage(): AuthenticationStorageInterface
    {
        return $this->authStorage;
    }

    /**
     * @param AuthenticationStorageInterface $authStorage
     */
    public function setAuthStorage(AuthenticationStorageInterface $authStorage): void
    {
        $this->authStorage = $authStorage;
    }

    /**
     * @return bool
     */
    public function isSandboxMode(): bool
    {
        return $this->sandboxMode;
    }

    /**
     * @param bool $sandboxMode
     */
    public function setSandboxMode(bool $sandboxMode): void
    {
        $this->sandboxMode = $sandboxMode;
    }

    /**
     * @return GuzzlClient
     */
    public function getClient(): GuzzlClient
    {
        return $this->client;
    }

    /**
     * @param GuzzlClient $client
     */
    public function setClient(GuzzlClient $client): void
    {
        $this->client = $client;
    }
}
