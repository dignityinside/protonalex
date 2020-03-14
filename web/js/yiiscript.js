/**
 * @author Alexander Schilling
 * @package app/yiiscript
 */

var app = app || {};

app.yiiscript = (function($) {

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
    app.yiiscript.init();
});
