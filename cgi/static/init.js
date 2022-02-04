"use strict";
function main() {
    load('main');
}
function load(name) {
    load_style(name);
    load_script(name);
}
function load_script(name) {
    var scriptElement = document.createElement('script');
    scriptElement.src = "".concat(name, ".js");
    document.body.appendChild(scriptElement);
}
function save_script(content) {
    var scriptElement = document.createElement('script');
    scriptElement.textContent = content;
    document.body.appendChild(scriptElement);
}
function load_style(name) {
    var styleElement = document.createElement('link');
    styleElement.rel = 'stylesheet';
    styleElement.href = "".concat(name, ".css");
    document.head.appendChild(styleElement);
}
function save_style(content) {
    var styleElement = document.createElement('link');
    styleElement.textContent = content;
    styleElement.href = "".concat(name, ".css");
    document.head.appendChild(styleElement);
}
function addEvent(tag, event, callback) {
    return tag.addEventListener ? tag.addEventListener(event, callback, false) : tag.attachEvent('on' + event, callback);
}
function event(event) {
    return event = event || window.event;
}
function prevent(event) {
    event.returnValue = false;
    event.preventDefault();
}
function eventOrigin(event) {
    return event.relatedTarget || event.fromElement;
}
function eventTarget(event) {
    return event.target || event.srcElement;
}
function getTextOf(tag) {
    return tag.textContent || tag.innerText || '';
}
function XMLHTTP() {
    return XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
}
