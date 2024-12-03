// npm package: flatpickr
// github link: https://github.com/flatpickr/flatpickr

$(function() {
  'use strict';

  const locale = "{{ app()->getLocale() }}";

  // date picker
  if ($('#flatpickr-date').length) {
    flatpickr("#flatpickr-date", {
      wrap: true,
      dateFormat: "Y-m-d",
      minDate: "today", // Prevent dates before today
    });
  }

  // time picker
  if ($('#flatpickr-time').length) {
    flatpickr("#flatpickr-time", {
      wrap: true,
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
    });
  }

  // datetime picker
  if ($('#flatpickr-datetime').length) {
    flatpickr("#flatpickr-datetime", {
      enableTime: true,
      wrap: true,
      dateFormat: "Y/m/d h:i K",
      minDate: "today", // Prevent dates before today
      locale: typeof flatPickrLanguage !== 'undefined' ? flatPickrLanguage : 'en',
    });
  }
});
