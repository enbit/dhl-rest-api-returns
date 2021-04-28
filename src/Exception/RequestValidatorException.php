<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Exception;

/**
 * Class RequestValidatorException
 *
 * A special instance of the DetailedServiceException which is
 * caused by invalid request data before a web service request was sent.
 *
 * @api
 * @author Ahmad Saad Aldin <as@enbit.de>
 * @link   https://netresearch.de
 */
class RequestValidatorException extends DetailedServiceException
{
}
