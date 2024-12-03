// npm package: flatpickr
// github link: https://github.com/flatpickr/flatpickr

$(function() {
  'use strict';

  const locale = "{{ app()->getLocale() }}";

  // date picker 
  if($('#flatpickr-date').length) {
    flatpickr("#flatpickr-date", {
      wrap: true,
      dateFormat: "Y-m-d",
    });
  }

  // time picker
  if($('#flatpickr-time').length) {
    flatpickr("#flatpickr-time", {
      wrap: true,
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
    });
  }

  if($('#flatpickr-datetime').length) {
    flatpickr("#flatpickr-datetime", {
      enableTime: true,
      wrap: true,
      dateFormat: "Y/m/d h:i K",
      // locale: "ar"
      locale: typeof flatPickrLanguage !== 'undefined' ? flatPickrLanguage : 'en',
    });
  }


});