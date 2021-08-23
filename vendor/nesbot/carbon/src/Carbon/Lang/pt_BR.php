<?php

/**
 * This file is part of the Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Authors:
 * - Cassiano Montanari
 * - Eduardo Dalla Vecchia
 * - David Rodrigues
 * - Matt Pope
 * - François B
 * - Prodis
 * - Marlon Maxwel
 * - JD Isaacks
 * - Raphael Amorim
 * - Rafael Raupp
 * - felipeleite1
 * - swalker
 * - Lucas Macedo
 * - Paulo Freitas
 * - Sebastian Thierer
 */
return array_replace_recursive(require __DIR__.'/pt.php', [
    'period_recurrences' => 'uma|:count vez',
    'period_interval' => 'toda :interval',
    'formats' => [
        'LLL' => 'D [de] MMMM [de] YYYY [às] HH:mm',
        'LLLL' => 'dddd, D [de] MMMM [de] YYYY [às] HH:mm',
    ],
    'months' => ['janeiro', 'fevereiro', 'marco', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'],
    'months_short' => ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'],
    'weekdays' => ['domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'],
    'weekdays_short' => ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sáb'],
    'weekdays_min' => ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sáb'],
    'first_day_of_week' => 0,
    'day_of_first_week_of_year' => 1,
]);
