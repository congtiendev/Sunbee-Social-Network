/* ----------------- Start Document ----------------- */
$(document).ready(function () {
  (function (window, document, undefined) {
    "use strict";
    if (!("localStorage" in window)) return;
    var nightMode = localStorage.getItem("gmtNightMode");
    if (nightMode) {
      document.documentElement.className += " night-mode";
    }
  })(window, document);

  (function (window, document, undefined) {
    "use strict";
    if (!("localStorage" in window)) return;
    var nightMode = document.querySelector("#night-mode");
    if (!nightMode) return;

    nightMode.addEventListener(
      "click",
      function (event) {
        event.preventDefault();
        document.documentElement.classList.toggle("dark");
        if (document.documentElement.classList.contains("dark")) {
          localStorage.setItem("gmtNightMode", true);
          return;
        }
        localStorage.removeItem("gmtNightMode");
      },
      false
    );
  })(window, document);

  $(".story").click(function () {
    const userID = $(this).data("user-id");
    const storyID = $(this).data("story-id");
    const storyUser = $(
      `.story-user[data-story-id=${storyID}][data-user-id=${userID}]`
    );
    $(".story-users-list").removeClass("uk-active");
    storyUser.addClass("uk-active").siblings().removeClass("uk-active");
    const storyContent = $(`#story-content-${storyID}`);
    storyContent.prependTo("#story_slider");
    UIkit.switcher("#story_slider").show(storyContent);
  });

  $(".story-user").click(function () {
    const userID = $(this).data("user-id");
    const storyID = $(this).data("story-id");
    const storyUser = $(
      `.story-user[data-story-id=${storyID}][data-user-id=${userID}]`
    );
    $(".story-users-list").removeClass("uk-active");
    storyUser.addClass("uk-active").siblings().removeClass("uk-active");
    const storyContent = $(`#story-content-${storyID}`);
    storyContent.prependTo("#story_slider");
    UIkit.switcher("#story_slider").show(storyContent);
  });
});
(function ($) {
  "use strict";

  $(document).ready(function () {
    /*----------------------------------------------------*/
    /* Sidebar Nav submenu
        /*----------------------------------------------------*/

    $(".sidebar_inner ul li a").on("click", function (e) {
      if ($(this).closest("li").children("ul").length) {
        if ($(this).closest("li").is(".active-submenu")) {
          $(".sidebar_inner ul li").removeClass("active-submenu");
        } else {
          $(".sidebar_inner ul li").removeClass("active-submenu");
          $(this).parent("li").addClass("active-submenu");
        }
        e.preventDefault();
      }
    });

    /*--------------------------------------------------*/
    /*  Keywords
        /*--------------------------------------------------*/
    $(".keywords-container").each(function () {
      var keywordInput = $(this).find(".keyword-input");
      var keywordsList = $(this).find(".keywords-list");

      // adding keyword
      function addKeyword() {
        var $newKeyword = $(
          "<span class='keyword'><span class='keyword-remove'></span><span class='keyword-text'>" +
            keywordInput.val() +
            "</span></span>"
        );
        keywordsList.append($newKeyword).trigger("resizeContainer");
        keywordInput.val("");
      }

      // add via enter key
      keywordInput.on("keyup", function (e) {
        if (e.keyCode == 13 && keywordInput.val() !== "") {
          addKeyword();
        }
      });

      // add via button
      $(".keyword-input-button").on("click", function () {
        if (keywordInput.val() !== "") {
          addKeyword();
        }
      });

      // removing keyword
      $(document).on("click", ".keyword-remove", function () {
        $(this).parent().addClass("keyword-removed");

        function removeFromMarkup() {
          $(".keyword-removed").remove();
        }
        setTimeout(removeFromMarkup, 500);
        keywordsList.css({ height: "auto" }).height();
      });

      // animating container height
      keywordsList.on("resizeContainer", function () {
        var heightnow = $(this).height();
        var heightfull = $(this)
          .css({ "max-height": "auto", height: "auto" })
          .height();

        $(this).css({ height: heightnow }).animate({ height: heightfull }, 200);
      });

      $(window).on("resize", function () {
        keywordsList.css({ height: "auto" }).height();
      });

      // Auto Height for keywords that are pre-added
      $(window).on("load", function () {
        var keywordCount = $(".keywords-list").children("span").length;

        // Enables scrollbar if more than 3 items
        if (keywordCount > 0) {
          keywordsList.css({ height: "auto" }).height();
        }
      });
    });

    /*--------------------------------------------------*/
    /*  Tippy JS 
        /*--------------------------------------------------*/
    /* global tippy */
    tippy("[data-tippy-placement]", {
      delay: 100,
      arrow: true,
      arrowType: "sharp",
      size: "regular",
      duration: 200,

      // 'shift-toward', 'fade', 'scale', 'perspective'
      animation: "shift-away",

      animateFill: true,
      theme: "dark",

      // How far the tooltip is from its reference element in pixels
      distance: 10,
    });

    // ------------------ End Document ------------------ //
  });
})(this.jQuery);

// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (
  localStorage.theme === "dark" ||
  (!("theme" in localStorage) &&
    window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
  document.documentElement.classList.add("dark");
} else {
  document.documentElement.classList.remove("dark");
}

// Whenever the user explicitly chooses light mode
localStorage.theme = "light";

// Whenever the user explicitly chooses dark mode
localStorage.theme = "dark";

// Whenever the user explicitly chooses to respect the OS preference
localStorage.removeItem("theme");
