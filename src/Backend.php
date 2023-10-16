<?php

declare(strict_types=1);

namespace Dotclear\Plugin\emailOptionnel;

use Dotclear\App;
use Dotclear\Core\Process;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Label,
    Para
};
use Dotclear\Interface\Core\BlogSettingsInterface;

/**
 * @brief       emailOptionnel backend class.
 * @ingroup     emailOptionnel
 *
 * @author      Oleksandr Syenchuk (author)
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
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

        App::behavior()->addBehaviors([
            'adminBlogPreferencesFormV2' => function (BlogSettingsInterface $blog_settings): void {
                echo
                '<div class="fieldset">' .
                '<h4 id="emailOptionnelParam">' . __('Optional e-mail address') . '</h4>' .
                (new Para())->__call('items', [[
                    (new Checkbox(My::id() . '_enabled', (bool) $blog_settings->get(My::id())->get('enabled')))->__call('value', [1]),
                    (new Label(__('Make e-mail address optional in comments'), Label::OUTSIDE_LABEL_AFTER))->__call('for', [My::id() . '_enabled'])->__call('class', ['classic']),
                ]])->render() .
                '</div>';
            },
            'adminBeforeBlogSettingsUpdate' => function (BlogSettingsInterface $blog_settings): void {
                $blog_settings->get(My::id())->put(
                    'enabled',
                    !empty($_POST[My::id() . '_enabled']),
                    'boolean',
                    __('Make e-mail address optional in comments')
                );
            },
        ]);

        return true;
    }
}
