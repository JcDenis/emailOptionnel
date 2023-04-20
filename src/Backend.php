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

use dcCore;
use dcNsProcess;
use dcSettings;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Label,
    Para
};

class Backend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = defined('DC_CONTEXT_ADMIN');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->addBehavior('adminBlogPreferencesFormV2', function (): void {
            // nullsafe PHP < 8.0
            if (is_null(dcCore::app()->blog)) {
                return;
            }

            echo
            '<div class="fieldset">' .
            '<h4 id="emailOptionnelParam">' . __('Optional e-mail address') . '</h4>' .
            (new Para())->items([
                (new Checkbox(My::SETTING_NAME, (bool) dcCore::app()->blog->settings->get(My::SETTING_NAME)->get('enabled')))->value(1),
                (new Label(__('Make e-mail address optional in comments'), Label::OUTSIDE_LABEL_AFTER))->for(My::SETTING_NAME)->class('classic'),
            ])->render() .
            '</div>';
        });

        dcCore::app()->addBehavior('adminBeforeBlogSettingsUpdate', function (dcSettings $blog_settings): void {
            $blog_settings->get(My::SETTING_NAME)->put(
                'enabled',
                !empty($_POST[My::SETTING_NAME]),
                'boolean',
                __('Make e-mail address optional in comments')
            );
        });

        return true;
    }
}
