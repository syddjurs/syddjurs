(function ($) {

/**
 * Main menu.
 */
Drupal.behaviors.BalkMainMenu = {
  attach: function (context, settings) {
    $('.region-menu ul.menu > li').hover(
      function() {
        $('a', $(this)).addClass('open');
        $('.submenu', $(this)).show();
      },
      function(event) {
        // In IE: On select element the mouseleave event hides the menu.
        // Prevent this by returning false if the event target is a select element.
        $target = $(event.target);
        if ( $target.is("select") ) return false;
        
        $('a', $(this)).removeClass('open');
        $('.submenu', $(this)).hide();
      });
    $('.region-menu ul.menu > li.l1 > a').attr('href', '#');
    $('.region-menu ul.menu > li.l1 > a').click(function(){
        return false;
    });
  }
};

/**
 * Header - Seconday menu.
 */
Drupal.behaviors.BalkSecondaryMenu = {
  attach: function (context, settings) {
    $('.region-header-first ul.menu > li.expanded > a').attr('href', '#');
    $('.region-header-first ul.menu > li.expanded').click(function() {
      $(this).toggleClass('shown');
    });
  }
};

/**
 * Enhance Jump menus in order to open external links in a new window.
 */
Drupal.behaviors.BalkJumpMenus = {
  attach: function (context, settings) {
    balkJumpMenusAttach(context);
  }
};

/**
 * Styled forms (Uniform library).
 */
Drupal.behaviors.uniform = {
  attach: function (context, settings) {
    $(".jump-quickly select, .styled-form select, .styled-form input:checkbox, .styled-form input:radio, .styled-form input:file").uniform();
  }
};

/**
 * HTML5 Placeholder.
 */
Drupal.behaviors.HTML5Placeholder = {
  attach: function (context, settings) {
    $('input[placeholder], textarea[placeholder]').placeholder();
  }
};

function balkJumpMenusAttach(context) {
  // Strip the host name down, removing ports, subdomains, or www.
  var pattern = /^(([^\/:]+?\.)*)([^\.:]{4,})((\.[a-z]{1,4})*)(:[0-9]{1,5})?$/;
  var host = window.location.host.replace(pattern, '$3$4');
  var subdomain = window.location.host.replace(pattern, '$1');

  // Determine what subdomains are considered internal.
  if (subdomain == 'www.' || subdomain == '') {
    var subdomains = "(www\\.)?";
  }
  else {
    var subdomains = subdomain.replace(".", "\\.");
  }

  // Build regular expressions that define an internal link.
  var internal_link = new RegExp("^https?://" + subdomains + host, "i");
  
  $(".jump-quickly .form-submit").click(function () {
    try {
      var $form = $(this).parents('form');

      var url = $(".form-select", $(this).parent()).val();
      if (url.indexOf('http') == 0 && (!url.match(internal_link))) {
        $form.attr('target', '_blank');
      }
      else {
        $form.attr('target', '');
      }
      $form.submit();
    }
    // IE7 throws errors often when dealing with irregular links, such as:
    // <a href="node/10"></a> Empty tags.
    // <a href="http://user:pass@example.com">example</a> User:pass syntax.
    catch(error) {
      return false;
    }
    
    return false;
  });
}

})(jQuery);
