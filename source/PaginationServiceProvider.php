<?php

/**
 * Part of the SilexPagination
 *
 * @author  Kilte Leichnam <nwotnbm@gmail.com>
 * @package SilexPagination
 */

namespace Kilte\Silex\Pagination;

use Kilte\Pagination\Pagination;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * PaginationServiceProvider Class
 *
 * @package Kilte\Silex\Pagination
 */
class PaginationServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $pimple)
    {
        $pimple['pagination.per_page']   = isset($pimple['pagination.per_page']) ? (int) $pimple['pagination.per_page'] : 20;
        $pimple['pagination.neighbours'] = isset($pimple['pagination.neighbours']) ? (int) $pimple['pagination.neighbours'] : 4;
        $pimple['pagination']            = $pimple->protect(
            function ($total, $current, $perPage = null, $neighbours = null) use ($pimple) {
                if ($perPage === null) {
                    $perPage = $pimple['pagination.per_page'];
                }
                if ($neighbours === null) {
                    $neighbours = $pimple['pagination.neighbours'];
                }

                return new Pagination($total, $current, $perPage, $neighbours);
            }
        );
    }
}
