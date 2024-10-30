window.onload = function() {
    var pres = document.getElementsByTagName('pre');
    for(var i = 0; i < pres.length; i++) {
        var pre = pres[i];
        var button = document.createElement('button');
        button.innerText = 'Copy';
        button.className = 'copy-button';
        button.onclick = ingenidev_copyToClipboard;
        var wrapper = document.createElement('div');
        wrapper.className = 'pre-wrapper';
        pre.parentNode.insertBefore(wrapper, pre);
        wrapper.appendChild(pre);
        wrapper.appendChild(button);
    }
}

function ingenidev_copyToClipboard() {
    var wrapper = this.parentNode;
    var button = this;
    var pre = wrapper.firstChild;
    var content =  pre.innerText;
    if (window.location.protocol === 'https:') {
        navigator.clipboard.writeText(content).then(function() {
            button.innerText="Copied";
            setTimeout(function(){
                button.innerText = 'Copy';
            }, 1000);
        }, function(err) {
        });
    } else {
        var textarea = document.createElement('textarea');
        textarea.value = content;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        button.innerText="Copied";
        setTimeout(function(){
            button.innerText = 'Copy';
        }, 1000);
    }
}