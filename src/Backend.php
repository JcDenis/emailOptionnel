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
use dcSettings;
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Label,
    Para
};

class Backend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        dcCore::app()->addBehavior('adminBlogPreferencesFormV2', function (dcSettings $blog_settings): void {
            echo
            '<div class="fieldset">' .
            '<h4 id="emailOptionnelParam">' . __('Optional e-mail address') . '</h4>' .
            (new Para())->__call('items', [[
                (new Checkbox(My::id() . '_enabled', (bool) $blog_settings->get(My::id())->get('enabled')))->__call('value', [1]),
                (new Label(__('Make e-mail address optional in comments'), Label::OUTSIDE_LABEL_AFTER))->__call('for', [My::id() . '_enabled'])->__call('class', ['classic']),
            ]])->render() .
            '</div>';
        });

        dcCore::app()->addBehavior('adminBeforeBlogSettingsUpdate', function (dcSettings $blog_settings): void {
            $blog_settings->get(My::id())->put(
                'enabled',
                !empty($_POST[My::id() . '_enabled']),
                'boolean',
                __('Make e-mail address optional in comments')
            );
        });

        return true;
    }
}
