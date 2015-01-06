if (typeof PDFJS === 'undefined') {
  (typeof window !== 'undefined' ? window : this).PDFJS = {};
}

//#if BUNDLE_VERSION
//#expand PDFJS.version = '__BUNDLE_VERSION__';
//#endif
//#if BUNDLE_BUILD
//#expand PDFJS.build = '__BUNDLE_BUILD__';
//#endif

(function pdfjsWrapper() {
  // Use strict in our context only - users might not want it
  'use strict';

//#expand __BUNDLE__

}).call((typeof window === 'undefined') ? this : window);

//#if !(MOZCENTRAL || FIREFOX)
if (!PDFJS.workerSrc && typeof document !== 'undefined') {
  // workerSrc is not set -- using last script url to define default location
  PDFJS.workerSrc = (function () {
    'use strict';
    var scriptTagContainer = document.body ||
                             document.getElementsByTagName('head')[0];
    var pdfjsSrc = scriptTagContainer.lastChild.src;
    return pdfjsSrc && pdfjsSrc.replace(/\.js$/i, '.worker.js');
  })();
}