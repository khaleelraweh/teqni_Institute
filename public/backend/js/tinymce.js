// npm package: tinymce
// github link: https://github.com/tinymce/tinymce

$(function() {
  'use strict';

  //Tinymce editor
  if ($("#tinymceExample").length) {
    tinymce.init({
      // selector: '#tinymceExample',
      selector: 'textarea',
      language: typeof tinymceLanguage !== 'undefined' ? tinymceLanguage : 'en', // Default to 'en' if no language set
      min_height: 350,
      default_text_color: 'red',
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table  directionality emoticons template paste ",
      ],
      toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
      image_advtab: true,
      templates: [{
          title: 'Test template 1',
          content: 'Test 1'
        },
        {
          title: 'Test template 2',
          content: 'Test 2'
        }
      ],
      content_css: []
    });
  }

});