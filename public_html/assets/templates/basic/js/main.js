(function ($) {
  "use strict";

  // ============== Header Hide Click On Body Js Start ========
  $(".header-button").on("click", function () {
    $(".body-overlay").toggleClass("show");
  });
  $(".body-overlay").on("click", function () {
    $(".header-button").trigger("click");
    $(this).removeClass("show");
  });
  // =============== Header Hide Click On Body Js End =========

  // =========================  Increament & Decreament Js Start =====================
  const productQty = $(".product-qty");
  productQty.each(function () {
    const qtyIncrement = $(this).find(".product-qty__increment");
    const qtyDecrement = $(this).find(".product-qty__decrement");
    let qtyValue = $(this).find(".product-qty__value");
    qtyIncrement.on("click", function () {
      var oldValue = parseFloat(qtyValue.val());
      var newVal = oldValue + 1;
      qtyValue.val(newVal).trigger("change");
    });
    qtyDecrement.on("click", function () {
      var oldValue = parseFloat(qtyValue.val());
      console.log(oldValue);

      if (oldValue <= 0) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue - 1;
      }
      qtyValue.val(newVal).trigger("change");
    });
  });
  // ========================= Increament & Decreament Js End =====================

  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {
    // ========================== Header Hide Scroll Bar Js Start =====================
    $(".navbar-toggler.header-button").on("click", function () {
      $("body").toggleClass("scroll-hidden-sm");
    });
    $(".body-overlay").on("click", function () {
      $("body").removeClass("scroll-hidden-sm");
    });
    // ========================== Header Hide Scroll Bar Js End =====================

    // ================== Password Show Hide Js Start ==========
    $(".toggle-password").on("click", function () {
      $(this).toggleClass(" fa-eye-slash");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    // =============== Password Show Hide Js End =================

    // ===================== Table Delete Column Js Start =================
    $(".delete-icon").on("click", function () {
      $(this).closest("tr").addClass("d-none");
    });
    // ===================== Table Delete Column Js End =================

    // header search btn

    $(".section__search-btn").on("click", function () {
      $(this).toggleClass("active");
      $(".section-search-form").toggleClass("active");
    });

    $(document).on("click touchstart", function (e) {
      if (
        !$(e.target).is(
          ".section__search-btn, .section__search-btn *, .section-search-form, .section-search-form *"
        )
      ) {
        $(".section-search-form").removeClass("active");
        $(".section__search-btn").removeClass("active");
      }
    });

    // ========================= Slick Slider Js End ===================

    // ============================ToolTip Js Start=====================
    const tooltipTriggerList = document.querySelectorAll(
      '[data-bs-toggle="tooltip"]'
    );
    const tooltipList = [...tooltipTriggerList].map(
      (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
    );
    // ============================ToolTip Js End========================

    // ================== Sidebar Menu Js Start ===============
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").click(function () {
      $(".sidebar-submenu").slideUp(200);
      if ($(this).parent().hasClass("active")) {
        $(".has-dropdown").removeClass("active");
        $(this).parent().removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });
    // Sidebar Dropdown Menu End

    // Sidebar Icon & Overlay js
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    // Sidebar Icon & Overlay js
    // ===================== Sidebar Menu Js End =================

    // ==================== Dashboard User Profile Dropdown Start ==================
    $(".user-info__button").on("click", function () {
      $(".user-info-dropdown").toggleClass("show");
    });
    $(".user-info__button").attr("tabindex", -1).focus();

    $(".user-info__button").on("focusout", function () {
      $(".user-info-dropdown").removeClass("show");
    });
    // ==================== Dashboard User Profile Dropdown End ==================
  });
  // ==========================================
  //      End Document Ready function
  // ==========================================

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
    $(".preloader").fadeOut();
  });
  // ========================= Preloader Js End=====================

  // popup  js
  var videoItem = $(".video-pop");
  if (videoItem) {
    videoItem.magnificPopup({
      type: "iframe",
    });
  }

  // popup  js

  // ========================= Header Sticky Js Start ==============
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });
  // ========================= Header Sticky Js End===================

  //============================ Scroll To Top Icon Js Start =========
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });
  //========================= Scroll To Top Icon Js End ======================

  $('.custom--check [type="checkbox"]').on("click change", function () {
    $('.custom--check [type="checkbox"]').removeAttr("checked");
    $(this).attr("checked", true);
  });

  $(document).ready(function () {
    $("#fileUpload").fileUpload();
  });

  $(".image-upload").on("change", function () {
    proPicURL(this);
  });

  function proPicURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var preview = $(input).closest(".box").find(".mainFile");
        $(preview).css("background-image", "url(" + e.target.result + ")");
        $(input).closest(".box").find(".mainFile").addClass("js--no-default");
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(".custom--dropdown > .custom--dropdown__selected").on("click", function () {
    $(this).parent().toggleClass("open");
  });
  $(".custom--dropdown > .dropdown-list > .dropdown-list__item").on(
    "click",
    function () {
      $(
        ".custom--dropdown > .dropdown-list > .dropdown-list__item"
      ).removeClass("selected");
      $(this)
        .addClass("selected")
        .parent()
        .parent()
        .removeClass("open")
        .children(".custom--dropdown__selected")
        .html($(this).html());
    }
  );
  $(document).on("keyup", function (evt) {
    if ((evt.keyCode || evt.which) === 27) {
      $(".custom--dropdown").removeClass("open");
    }
  });
  $(document).on("click", function (evt) {
    if (
      $(evt.target).closest(".custom--dropdown > .custom--dropdown__selected")
        .length === 0
    ) {
      $(".custom--dropdown").removeClass("open");
    }
  });

  $(".image-upload-input").on("change", function () {
    proPicURL(this);
  });

  function proPicURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var preview = $(input)
          .closest(".image-upload-wrapper")
          .find(".image-upload-preview");
        $(preview).css("background-image", "url(" + e.target.result + ")");
        $(preview).addClass("has-image");
        $(preview).hide();
        $(preview).fadeIn(650);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(".influencer-slider").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 1000,
    pauseOnHover: true,
    speed: 2000,
    dots: false,
    arrows: false,
    prevArrow:
      '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
    nextArrow:
      '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
  });
})(jQuery);
