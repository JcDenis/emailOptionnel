<?php
/**
 * @brief emailOptionnel, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Oleksandr Syenchuk, Pierre Van Glabeke, Gvx and Contributors
 *
 * @copyright Jean-Crhistian Denis
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_CONTEXT_ADMIN')) {
    return null;
}

dcCore::app()->addBehavior('adminBlogPreferencesFormV2', function () {
    dcCore::app()->blog->settings->addNamespace(initEmailOptionnel::SETTING_NAME);

    echo
    '<div class="fieldset"><h4 id="emailOptionnelParam">' . __('Optional e-mail address') . '</h4>' .
    '<p>' . form::checkbox(
        initEmailOptionnel::SETTING_NAME,
        '1',
        dcCore::app()->blog->settings->__get(initEmailOptionnel::SETTING_NAME)->enabled ? true : false
    ) .
    '<label class="classic" for="' . initEmailOptionnel::SETTING_NAME . '">' . __('Make e-mail address optional in comments') . '</label></p>' .
    '</div>';
});

dcCore::app()->addBehavior('adminBeforeBlogSettingsUpdate', function ($blog_settings) {
    dcCore::app()->blog->settings->addNamespace(initEmailOptionnel::SETTING_NAME);

    $blog_settings->__get(initEmailOptionnel::SETTING_NAME)->put(
        'enabled',
        empty($_POST[initEmailOptionnel::SETTING_NAME]) ? false : true,
        'boolean',
        __('Make e-mail address optional in comments')
    );
});
