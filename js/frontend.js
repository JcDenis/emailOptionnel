// -- BEGIN LICENSE BLOCK ----------------------------------
// This file is part of Email Optionnel, a plugin for Dotclear.
//
// Copyright (c) 2007-2020 Oleksandr Syenchuk, Pierre Van Glabeke, Gvx
//
// Licensed under the GPL version 2.0 license.
// A copy is available in LICENSE file or at
// http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
// -- END LICENSE BLOCK ------------------------------------

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  const field = document.getElementById('c_mail');
  if (!field) {
    return;
  }
  field.removeAttribute('required');

  // Remove the required mark (asterisk) from the label
  const label = document.querySelector('label[for="c_mail"]');
  if (label) {
    label.classList.remove('required');
    for (const mark of label.querySelectorAll('span, abbr')) {
      if (mark.textContent.trim() === '*') {
        mark.remove();
      }
    }
  }
});
