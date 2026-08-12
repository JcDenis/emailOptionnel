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

if (!isset($this) || !is_object($this) || !method_exists($this, 'registerModule') || !isset($this->id) || !is_string($this->id)) {
    return;
}

$this->registerModule(
    'emailOptionnel',
    'Make e-mail address optional in comments',
    'Oleksandr Syenchuk, Pierre Van Glabeke, Gvx and Contributors',
    '1.8',
    [
        'requires'    => [['core', '2.39']],
        'permissions' => 'My',
        'settings'    => ['blog' => '#params.' . $this->id . '_params'],
        'type'        => 'plugin',
        'support'     => 'https://github.com/JcDenis/' . $this->id . '/issues',
        'details'     => 'https://github.com/JcDenis/' . $this->id . '/',
        'repository'  => 'https://raw.githubusercontent.com/JcDenis/' . $this->id . '/master/dcstore.xml',
        'date'        => '2026-08-12T20:56:24+00:00',
    ]
);
