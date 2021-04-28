# DHL Paket Retoure API SDK

The DHL Paket Retoure API SDK package offers an interface to the following web services:

- API Retoure

## Requirements

### System Requirements

- PHP 7.1+ with JSON extension

### Package Requirements

- `guzzlehttp/guzzle`

## Installation

```bash
$ composer require enbit/dhl-rest-api-returns
```

## Features

The DHL Paket Retoure API SDK supports the following features:

* Book return labels ([`BookLabel`](https://entwickler.dhl.de/group/ep/wsapis/retouren))

### Return Label Service

Create a return label PDF or QR code to be scanned by a place of committal (e.g. post office).
For return shipments from outside of the EU, a customs document can also be requested.

```php
use Enbit\Dhl\Retoure\Auth\AuthenticationStorage;
use Enbit\Dhl\Retoure\Service\ServiceFactory;
use Enbit\Dhl\Retoure\Model\ReturnLabelRequestBuilder;

$authStorage = new AuthenticationStorage(
    'applicationId',
    'applicationToken',
    'user',
    'signature'
);

$serviceFactory = new ServiceFactory(
    $authStorage,
    $sandbox = true
);
$service = $serviceFactory->createReturnLabelService();

$requestBuilder = new ReturnLabelRequestBuilder();
$requestBuilder->setAccountDetails($receiverId = 'DE');
$requestBuilder->setShipperAddress(
    $name = 'Jane Doe',
    $countryCode = 'DE',
    $postalCode = '53113',
    $city = 'Bonn',
    $streetName = 'Sträßchensweg',
    $streetNumber = '2'
);

$returnOrder = $requestBuilder->create();
$confirmation = $service->bookLabel($returnOrder);

$confirmation->getLabelData();
$confirmation->getQrLabelData();
$confirmation->getRoutingCode();
$confirmation->getShipmentNumber();

```
