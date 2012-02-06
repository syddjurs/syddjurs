(function ($) {
  Drupal.behaviors.balkSubsites = {
    attach: function (context) {
      var settings = new Object();
      settings.fit = 1;
      settings.cleartypeNoBg = true;
      settings.auto_slide = 1;
      settings.fx = "fade";
      settings.timeout = "8000";

      $('.subsite-banner-content', context).cycle(settings);
    }
  };
})(jQuery);
