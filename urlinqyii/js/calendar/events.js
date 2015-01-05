/// <reference path="lib/jquery.js" />
jQuery(function () {
    var scope = $(".ul-calendar");

    LeftPanel.addProvider("class", "Neurochemical foundations of behavior", "http://lorempixel.com/60/60", "a");
    LeftPanel.addProvider("class", "Theory of neuroscience", "http://lorempixel.com/60/60", "b");
    LeftPanel.addProvider("class", "Computaional Biology", "http://lorempixel.com/60/60", "c");
    LeftPanel.addProvider("class", "Web Programming", "http://lorempixel.com/60/60", "d");
    LeftPanel.addProvider("clubs", "this is a club", "http://lorempixel.com/60/60", "e");
    LeftPanel.addProvider("clubs", "Another club", "http://lorempixel.com/60/60", "f");
    LeftPanel.addProvider("depts", "Computer Science and Engineering", "http://lorempixel.com/60/60", "c");

    forceLeftMenuClose = true;
});