Ethenis = {
    load(){
        var linkElements = document.getElementsByClassName('__eth-link');
        Ethenis.loadLinks(linkElements);
    },
    
    loadContent(){
        var request = new XMLHttpRequest();
        var contentWrapper = document.getElementById('__eth-content');
        contentWrapper.style.opacity = 0;
        request.open('GET', Ethenis.getContentRealDir(), true);
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                contentWrapper.innerHTML = this.response;
                Ethenis.loadContentLinks();
                contentWrapper.style.opacity = 1;
            } else {
                console.log("Eth.loadContent Error:" + this.status);
            }
        };
        request.onerror = function() {
            console.log("Eth.loadContent FataError");
        };

        request.send();
    },
    
    getContentRealDir(){
        var path = window.location.pathname.substring(1);
        var realDir = "";
        for(var dir in __ETHENIS_CONFIG){
            var dirRegex = new RegExp(dir.substring(1, dir.length-1));
            if(path == dir ||
                    (/\/.*\//.test(dir) && dirRegex.test(path)))
                realDir = "/content/" + __ETHENIS_CONFIG[dir][0];
        }
        return realDir;
    },
    
    loadContentLinks(){
        var linkElements =
                document.querySelectorAll('#__eth-content .__eth-link');
        Ethenis.loadLinks(linkElements);
    },
    
    loadLinks(elements){
        if(elements != null)
            Array.prototype.forEach.call(elements, function(element){
                element.addEventListener('click', function(event){
                    event.preventDefault();
                    history.pushState('', '', element.getAttribute('href'));
                    Ethenis.loadContent();
                });
            });
    }
}


Ethenis.load();
