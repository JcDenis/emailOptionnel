<?php

declare(strict_types=1);

namespace Dotclear\Plugin\emailOptionnel;

use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;
use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Img;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Interface\Core\BlogSettingsInterface;

/**
 * @brief       emailOptionnel backend class.
 * @ingroup     emailOptionnel
 *
 * @author      Oleksandr Syenchuk (author)
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Backend
{
    use TraitProcess;

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
                echo (new Fieldset(My::id() . '_params'))
                    ->legend(new Legend((new Img(My::icons()[0]))->class('icon-small')->render() . ' ' . My::name()))
                    ->items([
                        (new Para())
                            ->items([
                                (new Checkbox(My::id() . '_enabled', (bool) $blog_settings->get(My::id())->get('enabled')))
                                    ->value(1)
                                    ->label(new Label(__('Make e-mail address optional in comments'), Label::IL_FT)),
                            ]),
                    ])
                    ->render();
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
