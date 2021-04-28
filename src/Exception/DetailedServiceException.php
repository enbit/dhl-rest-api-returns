<?php

/**
 * See LICENSE.md for license details.
 */

declare(strict_types=1);

namespace Enbit\Dhl\Retoure\Exception;

/**
 * Class DetailedServiceException
 *
 * A special instance of the ServiceException which is able to
 * provide a meaningful error message, suitable for UI display.
 *
 * @api
 * @author Rico Sonntag <rico.sonntag@netresearch.de>
 * @link   https://www.enbit.de/
 */
class DetailedServiceException extends ServiceException
{
}
