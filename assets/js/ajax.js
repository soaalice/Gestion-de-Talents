function createXHR() {
    var xhr;
    try { xhr = new ActiveXObject('Msxml2.XMLHTTP'); }
    catch (e) {
        try { xhr = new ActiveXObject('Microsoft.XMLHTTP'); }
        catch (e2) {
            try { xhr = new XMLHttpRequest(); }
            catch (e3) { xhr = false; }
        }
    }
    return xhr;
}


function sendXHR(xhr, method, url, async, body) {
    //XMLHttpRequest.open(method, url, async)
    xhr.open(method, url, async);

    //XMLHttpRequest.send(body)
    xhr.send(body);
}
