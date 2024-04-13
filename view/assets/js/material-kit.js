 //
 // =========================================================
 // * Material Kit - v2.0.6
 // =========================================================
 //
 // * Product Page: https://www.creative-tim.com/product/material-kit
 // * Copyright 2019 Creative Tim (http://www.creative-tim.com)
 //   Licensed under MIT (https://github.com/creativetimofficial/material-kit/blob/master/LICENSE.md)
 //
 //
 // =========================================================
 //
 // * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

 var big_image;

 $(document).ready(function() {
   BrowserDetect.init();
 
   // Init Material scripts for buttons ripples, inputs animations etc, more info on the next link https://github.com/FezVrasta/bootstrap-material-design#materialjs
   $('body').bootstrapMaterialDesign();
 
   window_width = $(window).width();
 
   $navbar = $('.navbar[color-on-scroll]');
   scroll_distance = $navbar.attr('color-on-scroll') || 500;
 
   $navbar_collapse = $('.navbar').find('.navbar-collapse');
 
   //  Activate the Tooltips
   $('[data-toggle="tooltip"], [rel="tooltip"]').tooltip();
 
   // Activate Popovers
   $('[data-toggle="popover"]').popover();
 
   if ($('.navbar-color-on-scroll').length != 0) {
     $(window).on('scroll', materialKit.checkScrollForTransparentNavbar);
   }
 
   materialKit.checkScrollForTransparentNavbar();
 
   if (window_width >= 768) {
     big_image = $('.page-header[data-parallax="true"]');
     if (big_image.length != 0) {
       $(window).on('scroll', materialKit.checkScrollForParallax);
     }
 
   }
 
 
 });
 
 // Returns a function, that, as long as it continues to be invoked, will not
 // be triggered. The function will be called after it stops being called for
 // N milliseconds. If `immediate` is passed, trigger the function on the
 // leading edge, instead of the trailing.
 
 function debounce(func, wait, immediate) {
   var timeout;
   return function() {
     var context = this,
       args = arguments;
     clearTimeout(timeout);
     timeout = setTimeout(function() {
       timeout = null;
       if (!immediate) func.apply(context, args);
     }, wait);
     if (immediate && !timeout) func.apply(context, args);
   };
 };
 
 var BrowserDetect = {
   init: function() {
     this.browser = this.searchString(this.dataBrowser) || "Other";
     this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
   },
   searchString: function(data) {
     for (var i = 0; i < data.length; i++) {
       var dataString = data[i].string;
       this.versionSearchString = data[i].subString;
 
       if (dataString.indexOf(data[i].subString) !== -1) {
         return data[i].identity;
       }
     }
   },
   searchVersion: function(dataString) {
     var index = dataString.indexOf(this.versionSearchString);
     if (index === -1) {
       return;
     }
 
     var rv = dataString.indexOf("rv:");
     if (this.versionSearchString === "Trident" && rv !== -1) {
       return parseFloat(dataString.substring(rv + 3));
     } else {
       return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
     }
   },
 
   dataBrowser: [{
       string: navigator.userAgent,
       subString: "Chrome",
       identity: "Chrome"
     },
     {
       string: navigator.userAgent,
       subString: "MSIE",
       identity: "Explorer"
     },
     {
       string: navigator.userAgent,
       subString: "Trident",
       identity: "Explorer"
     },
     {
       string: navigator.userAgent,
       subString: "Firefox",
       identity: "Firefox"
     },
     {
       string: navigator.userAgent,
       subString: "Safari",
       identity: "Safari"
     },
     {
       string: navigator.userAgent,
       subString: "Opera",
       identity: "Opera"
     }
   ]
 
 };
 
 var better_browser = '<div class="container"><div class="better-browser row"><div class="col-md-2"></div><div class="col-md-8"><h3>We are sorry but it looks like your Browser doesn\'t support our website Features. In order to get the full experience please download a new version of your favourite browser.</h3></div><div class="col-md-2"></div><br><div class="col-md-4"><a href="https://www.mozilla.org/ro/firefox/new/" class="btn btn-warning">Mozilla</a><br></div><div class="col-md-4"><a href="https://www.google.com/chrome/browser/desktop/index.html" class="btn ">Chrome</a><br></div><div class="col-md-4"><a href="http://windows.microsoft.com/en-us/internet-explorer/ie-11-worldwide-languages" class="btn">Internet Explorer</a><br></div><br><br><h4>Thank you!</h4></div></div>';
 