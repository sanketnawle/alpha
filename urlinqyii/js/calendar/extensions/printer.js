function outerHTML(node, cls) {
    var div = document.createElement('div'), h, printable = node.cloneNode(true);
    printable.classList.add(cls || "");
    div.appendChild(printable);
    h = div.innerHTML;
    div = null;
    return h;
}

ulcal.service("PrinterService", function ($timeout) {
    this.print = function (node) {
        var mywindow = window.open('', 'my div', 'height=695,width=900');
        mywindow.document.write('<html><head><title>my div</title>');
        mywindow.document.write('<link href="http://goo.gl/CHQFJX" rel="stylesheet" type="text/css">');
        mywindow.document.write('<link href="' + css_url + '/../font/avenir.css" rel="stylesheet" type="text/css">');
        mywindow.document.write('<link rel="stylesheet" href="' + css_url + '/master.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="' + css_url + '/week.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="' + css_url + '/month.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="' + css_url + '/header.css" type="text/css" />');
        mywindow.document.write('</head><body class="ul-calendar print">');
        mywindow.document.write(outerHTML(node, "print"));
        mywindow.document.write('</body></html>');
        $timeout(function () {
            mywindow.print();
            mywindow.close();
        }, 1000);
    }
});