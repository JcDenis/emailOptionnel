<?php
/**
 * @file
 * @brief       The plugin emailOptionnel definition
 * @ingroup     emailOptionnel
 *
 * @defgroup    emailOptionnel Plugin emailOptionnel.
 *
 * Make e-mail address optional in comments.
 *
 * @author      Oleksandr Syenchuk (author)
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

$this->registerModule(
    'emailOptionnel',
    'Make e-mail address optional in comments',
    'Oleksandr Syenchuk, Pierre Van Glabeke, Gvx and Contributors',
    '1.5',
    [
        'requires'    => [['core', '2.28']],
        'permissions' => 'My',
        'settings'    => ['blog' => '#params.' . basename(__DIR__) . 'Param'],
        'type'        => 'plugin',
        'support'     => 'https://github.com/JcDenis/' . basename(__DIR__) . '/issues',
        'details'     => 'https://github.com/JcDenis/' . basename(__DIR__) . '/src/branch/master/README.md',
        'repository'  => 'https://github.com/JcDenis/' . basename(__DIR__) . '/raw/branch/master/dcstore.xml',
    ]
);
