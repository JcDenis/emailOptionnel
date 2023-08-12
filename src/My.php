<?php
/**
 * @brief emailOptionnel, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Oleksandr Syenchuk, Pierre Van Glabeke, Gvx and Contributors
 *
 * @copyright Jean-Christian Denis
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\emailOptionnel;

use Dotclear\Module\MyPlugin;

/**
 * This module definitions.
 */
class My extends MyPlugin
{
    /** @var string Default email */
    public const DEFAULT_EMAIL = 'invalid@invalid.fr';
}
