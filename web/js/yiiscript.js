/**
 * @author Alexander Schilling
 * @package phpland/yiiscript
 */

var phpland = phpland || {};

phpland.yiiscript = (function($) {

    'use strict';

    return {

        init: function() {

            var $markdownEditor = $('.markdown-editor');

            if ($markdownEditor.length) {
                initEditor($markdownEditor);
            }

        }

    };

})($);

$(document).ready(function(){
    phpland.yiiscript.init();
});
