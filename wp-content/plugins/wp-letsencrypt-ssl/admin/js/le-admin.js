(function ($) {
  "use strict";

  $(".le-section-title").click(function () {
    var scn = $(this).attr("data-section");
    $(".le-section-title").removeClass("active");
    $(this).addClass("active");

    localStorage.setItem('le-state', scn);

    $(".le-section.active").fadeOut("fast").removeClass("active").promise().done(function () {
      $("." + scn).fadeIn("fast").addClass("active");
    });

  });

  //restore last tab
  if (localStorage.getItem('le-state') !== null) {
    var section = localStorage.getItem('le-state');

    $(".le-section-title[data-section=" + section + "]").click();
  }

  //Since 2.1.0
  $(".wple-dismiss").click(function () {

    jQuery.ajax({
      method: "POST",
      url: 'admin-ajax.php',
      dataType: "text",
      data: {
        action: 'wple_dismiss'
      },
      beforeSend: function () {

      },
      error: function () {

      },
      success: function (response) {
        $(".wplerateus").fadeOut("fast");
      }
    });

  });

  var handler = FS.Checkout.configure({
    plugin_id: '5090',
    plan_id: '8210',
    public_key: 'pk_f6a07c106bf4ef064d9ac4b989e02',
    image: 'https://gowebsmarty.com/wp-letsencrypt.png'
  });

  $('.le-buypro-button').on('click', function (e) {
    handler.open({
      name: 'WP Encryption',
      licenses: 1,
      // You can consume the response for after purchase logic.
      purchaseCompleted: function (response) {
        // The logic here will be executed immediately after the purchase confirmation.                                // alert(response.user.email);
      },
      success: function (response) {
        // The logic here will be executed after the customer closes the checkout, after a successful purchase.                                // alert(response.user.email);
      }
    });
    e.preventDefault();
  });

  // Since 2.5.0  
  $('.wple-tooltip').each(function () {
    var $this = $(this);

    tippy('.wple-tooltip', {
      //content: $this.attr('data-content'),
      placement: 'top',
      onShow(instance) {
        instance.popper.hidden = instance.reference.dataset.tippy ? false : true;
        instance.setContent(instance.reference.dataset.tippy);
      }
      //arrow: false
    });
  });

  $(".toggle-debugger").click(function () {
    $(this).find("span").toggleClass("rotate");

    $(".le-debugger").slideToggle('fast');
  });

})(jQuery);