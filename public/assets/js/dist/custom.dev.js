"use strict";

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

(function () {
  "use strict";
  /* tooltip */

  var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');

  var tooltipList = _toConsumableArray(tooltipTriggerList).map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  /* popover  */


  var popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');

  var popoverList = _toConsumableArray(popoverTriggerList).map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  }); //switcher color pickers


  var pickrContainerPrimary = document.querySelector('.pickr-container-primary');
  var themeContainerPrimary = document.querySelector('.theme-container-primary');
  var pickrContainerBackground = document.querySelector('.pickr-container-background');
  var themeContainerBackground = document.querySelector('.theme-container-background');
  /* for theme primary */

  var nanoThemes = [['nano', {
    defaultRepresentation: 'RGB',
    components: {
      preview: true,
      opacity: false,
      hue: true,
      interaction: {
        hex: false,
        rgba: true,
        hsva: false,
        input: true,
        clear: false,
        save: false
      }
    }
  }]];
  var nanoButtons = [];
  var nanoPickr = null;

  var _loop = function _loop() {
    var _nanoThemes$_i = _slicedToArray(_nanoThemes[_i], 2),
        theme = _nanoThemes$_i[0],
        config = _nanoThemes$_i[1];

    var button = document.createElement('button');
    button.innerHTML = theme;
    nanoButtons.push(button);
    button.addEventListener('click', function () {
      var el = document.createElement('p');
      pickrContainerPrimary.appendChild(el);
      /* Delete previous instance */

      if (nanoPickr) {
        nanoPickr.destroyAndRemove();
      }
      /* Apply active class */


      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = nanoButtons[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var btn = _step.value;
          btn.classList[btn === button ? 'add' : 'remove']('active');
        }
        /* Create fresh instance */

      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator["return"] != null) {
            _iterator["return"]();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      nanoPickr = new Pickr(Object.assign({
        el: el,
        theme: theme,
        "default": '#845adf'
      }, config));
      /* Set events */

      nanoPickr.on('changestop', function (source, instance) {
        var color = instance.getColor().toRGBA();
        var html = document.querySelector('html');
        html.style.setProperty('--primary-rgb', "".concat(Math.floor(color[0]), ", ").concat(Math.floor(color[1]), ", ").concat(Math.floor(color[2])));
        /* theme color picker */

        localStorage.setItem('primaryRGB', "".concat(Math.floor(color[0]), ", ").concat(Math.floor(color[1]), ", ").concat(Math.floor(color[2])));
        updateColors();
      });
    });
    themeContainerPrimary.appendChild(button);
  };

  for (var _i = 0, _nanoThemes = nanoThemes; _i < _nanoThemes.length; _i++) {
    _loop();
  }

  nanoButtons[0].click();
  /* for theme primary */

  /* for theme background */

  var nanoThemes1 = [['nano', {
    defaultRepresentation: 'RGB',
    components: {
      preview: true,
      opacity: false,
      hue: true,
      interaction: {
        hex: false,
        rgba: true,
        hsva: false,
        input: true,
        clear: false,
        save: false
      }
    }
  }]];
  var nanoButtons1 = [];
  var nanoPickr1 = null;

  var _loop2 = function _loop2() {
    var _nanoThemes2$_i = _slicedToArray(_nanoThemes2[_i2], 2),
        theme = _nanoThemes2$_i[0],
        config = _nanoThemes2$_i[1];

    var button = document.createElement('button');
    button.innerHTML = theme;
    nanoButtons1.push(button);
    button.addEventListener('click', function () {
      var el = document.createElement('p');
      pickrContainerBackground.appendChild(el);
      /* Delete previous instance */

      if (nanoPickr1) {
        nanoPickr1.destroyAndRemove();
      }
      /* Apply active class */


      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = nanoButtons[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var btn = _step2.value;
          btn.classList[btn === button ? 'add' : 'remove']('active');
        }
        /* Create fresh instance */

      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
            _iterator2["return"]();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }

      nanoPickr1 = new Pickr(Object.assign({
        el: el,
        theme: theme,
        "default": '#845adf'
      }, config));
      /* Set events */

      nanoPickr1.on('changestop', function (source, instance) {
        var color = instance.getColor().toRGBA();
        var html = document.querySelector('html');
        html.style.setProperty('--body-bg-rgb', "".concat(color[0], ", ").concat(color[1], ", ").concat(color[2]));
        document.querySelector('html').style.setProperty('--light-rgb', "".concat(color[0] + 14, ", ").concat(color[1] + 14, ", ").concat(color[2] + 14));
        document.querySelector('html').style.setProperty('--form-control-bg', "rgb(".concat(color[0] + 14, ", ").concat(color[1] + 14, ", ").concat(color[2] + 14, ")"));
        localStorage.removeItem("bgtheme");
        updateColors();
        html.setAttribute('data-theme-mode', 'dark');
        html.setAttribute('data-menu-styles', 'dark');
        html.setAttribute('data-header-styles', 'dark');
        document.querySelector('#switcher-dark-theme').checked = true;
        localStorage.setItem('bodyBgRGB', "".concat(color[0], ", ").concat(color[1], ", ").concat(color[2]));
        localStorage.setItem('bodylightRGB', "".concat(color[0] + 14, ", ").concat(color[1] + 14, ", ").concat(color[2] + 14));
      });
    });
    themeContainerBackground.appendChild(button);
  };

  for (var _i2 = 0, _nanoThemes2 = nanoThemes; _i2 < _nanoThemes2.length; _i2++) {
    _loop2();
  }

  nanoButtons1[0].click();
  /* for theme background */

  /* header theme toggle */

  function toggleTheme() {
    var html = document.querySelector('html');

    if (html.getAttribute('data-theme-mode') === "dark") {
      html.setAttribute('data-theme-mode', 'light');
      html.setAttribute('data-header-styles', 'light');
      html.setAttribute('data-menu-styles', 'light');
      html.removeAttribute('data-bg-theme');
      html.removeAttribute('style');
      document.querySelector('#switcher-light-theme').checked = true;
      document.querySelector('#switcher-menu-light').checked = true;
      document.querySelector('html').style.removeProperty('--body-bg-rgb', localStorage.bodyBgRGB);
      checkOptions();
      document.querySelector('#switcher-header-light').checked = true;
      document.querySelector('#switcher-menu-light').checked = true;
      document.querySelector('#switcher-light-theme').checked = true;
      document.querySelector("#switcher-background4").checked = false;
      document.querySelector("#switcher-background3").checked = false;
      document.querySelector("#switcher-background2").checked = false;
      document.querySelector("#switcher-background1").checked = false;
      document.querySelector("#switcher-background").checked = false;
      localStorage.removeItem("ynexdarktheme");
      localStorage.removeItem("ynexMenu");
      localStorage.removeItem("ynexHeader");
      localStorage.removeItem("bodylightRGB");
      localStorage.removeItem("bodyBgRGB");

      if (localStorage.getItem("ynexlayout") != "horizontal") {
        html.setAttribute("data-menu-styles", "dark");
      }

      html.setAttribute("data-header-styles", "light");
    } else {
      html.setAttribute('data-theme-mode', 'dark');
      html.setAttribute('data-header-styles', 'dark');
      html.setAttribute('data-menu-styles', 'dark');
      document.querySelector('#switcher-dark-theme').checked = true;
      document.querySelector('#switcher-menu-dark').checked = true;
      document.querySelector('#switcher-header-dark').checked = true;
      checkOptions();
      document.querySelector('#switcher-menu-dark').checked = true;
      document.querySelector('#switcher-header-dark').checked = true;
      document.querySelector('#switcher-dark-theme').checked = true;
      document.querySelector("#switcher-background4").checked = false;
      document.querySelector("#switcher-background3").checked = false;
      document.querySelector("#switcher-background2").checked = false;
      document.querySelector("#switcher-background1").checked = false;
      document.querySelector("#switcher-background").checked = false;
      localStorage.setItem("ynexdarktheme", "true");
      localStorage.setItem("ynexMenu", "dark");
      localStorage.setItem("ynexHeader", "dark");
      localStorage.removeItem("bodylightRGB");
      localStorage.removeItem("bodyBgRGB");
    }
  }

  var layoutSetting = document.querySelector(".layout-setting");

  if (layoutSetting) {
    layoutSetting.addEventListener("click", toggleTheme);
  }
  /* header theme toggle */

  /* Choices JS */


  document.addEventListener('DOMContentLoaded', function () {
    var genericExamples = document.querySelectorAll('[data-trigger]');

    for (var _i3 = 0; _i3 < genericExamples.length; ++_i3) {
      var element = genericExamples[_i3];
      new Choices(element, {
        allowHTML: true,
        placeholderValue: 'This is a placeholder set in the config',
        searchPlaceholderValue: 'Search'
      });
    }
  });
  /* Choices JS */

  /* footer year */

  document.getElementById("year").innerHTML = new Date().getFullYear();
  /* footer year */

  /* node waves */

  Waves.attach('.btn-wave', ['waves-light']);
  Waves.init();
  /* node waves */

  /* card with close button */

  var DIV_CARD = '.card';
  var cardRemoveBtn = document.querySelectorAll('[data-bs-toggle="card-remove"]');
  cardRemoveBtn.forEach(function (ele) {
    ele.addEventListener('click', function (e) {
      e.preventDefault();
      var $this = this;
      var card = $this.closest(DIV_CARD);
      card.remove();
      return false;
    });
  });
  /* card with close button */

  /* card with fullscreen */

  var cardFullscreenBtn = document.querySelectorAll('[data-bs-toggle="card-fullscreen"]');
  cardFullscreenBtn.forEach(function (ele) {
    ele.addEventListener('click', function (e) {
      var $this = this;
      var card = $this.closest(DIV_CARD);
      card.classList.toggle('card-fullscreen');
      card.classList.remove('card-collapsed');
      e.preventDefault();
      return false;
    });
  });
  /* card with fullscreen */

  /* count-up */

  var i = 1;
  setInterval(function () {
    document.querySelectorAll(".count-up").forEach(function (ele) {
      if (ele.getAttribute("data-count") >= i) {
        i = i + 1;
        ele.innerText = i;
      }
    });
  }, 10);
  /* count-up */

  /* back to top */

  var scrollToTop = document.querySelector(".scrollToTop");
  var $rootElement = document.documentElement;
  var $body = document.body;

  window.onscroll = function () {
    var scrollTop = window.scrollY || window.pageYOffset;
    var clientHt = $rootElement.scrollHeight - $rootElement.clientHeight;

    if (window.scrollY > 100) {
      scrollToTop.style.display = "flex";
    } else {
      scrollToTop.style.display = "none";
    }
  };

  scrollToTop.onclick = function () {
    window.scrollTo(0, 0);
  };
  /* back to top */

  /* header dropdowns scroll */


  var myHeaderShortcut = document.getElementById('header-shortcut-scroll');
  new SimpleBar(myHeaderShortcut, {
    autoHide: true
  });
  var myHeadernotification = document.getElementById('header-notification-scroll');
  new SimpleBar(myHeadernotification, {
    autoHide: true
  });
  var myHeaderCart = document.getElementById('header-cart-items-scroll');
  new SimpleBar(myHeaderCart, {
    autoHide: true
  });
  /* header dropdowns scroll */
})();
/* full screen */


var elem = document.documentElement;

function openFullscreen() {
  var open = document.querySelector('.full-screen-open');
  var close = document.querySelector('.full-screen-close');

  if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) {
      /* Safari */
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      /* IE11 */
      elem.msRequestFullscreen();
    }

    close.classList.add('d-block');
    close.classList.remove('d-none');
    open.classList.add('d-none');
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
      /* Safari */
      document.webkitExitFullscreen();
      console.log("working");
    } else if (document.msExitFullscreen) {
      /* IE11 */
      document.msExitFullscreen();
    }

    close.classList.remove('d-block');
    open.classList.remove('d-none');
    close.classList.add('d-none');
    open.classList.add('d-block');
  }
}
/* full screen */

/* toggle switches */


var customSwitch = document.querySelectorAll('.toggle');
customSwitch.forEach(function (e) {
  return e.addEventListener('click', function () {
    e.classList.toggle("on");
  });
});
/* toggle switches */

/* header dropdown close button */

/* for cart dropdown */

var headerbtn = document.querySelectorAll('.dropdown-item-close');
headerbtn.forEach(function (button) {
  button.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    button.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
    document.getElementById("cart-data").innerText = "".concat(document.querySelectorAll('.dropdown-item-close').length, " Items");
    document.getElementById("cart-icon-badge").innerText = "".concat(document.querySelectorAll('.dropdown-item-close').length);
    console.log(document.getElementById("header-cart-items-scroll").children.length);

    if (document.querySelectorAll('.dropdown-item-close').length == 0) {
      var elementHide = document.querySelector(".empty-header-item");
      var elementShow = document.querySelector(".empty-item");
      elementHide.classList.add("d-none");
      elementShow.classList.remove("d-none");
    }
  });
});
/* for cart dropdown */

/* for notifications dropdown */

var headerbtn1 = document.querySelectorAll('.dropdown-item-close1');
headerbtn1.forEach(function (button) {
  button.addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    button.parentNode.parentNode.parentNode.parentNode.remove();
    document.getElementById("notifiation-data").innerText = "".concat(document.querySelectorAll('.dropdown-item-close1').length, " Unread");
    document.getElementById("notification-icon-badge").innerText = "".concat(document.querySelectorAll('.dropdown-item-close1').length);

    if (document.querySelectorAll('.dropdown-item-close1').length == 0) {
      var elementHide1 = document.querySelector(".empty-header-item1");
      var elementShow1 = document.querySelector(".empty-item1");
      elementHide1.classList.add("d-none");
      elementShow1.classList.remove("d-none");
    }
  });
});
/* for notifications dropdown */