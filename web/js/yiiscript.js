$("document").ready(function() {

    var $markdownEditor = $('.markdown-editor');

    if ($markdownEditor.length) {
        initEditor($markdownEditor);
    }

});