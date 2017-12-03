Ethenis = {
    load(){
        var linkElements = document.getElementsByClassName('__eth-link');
        Array.prototype.forEach.call(linkElements, function(element){
            element.addEventListener('click', function(event){
                event.preventDefault();
                history.pushState('', '', element.getAttribute('href'));
                Ethenis.loadContent();
            });
        });
    },
    
    loadContent(){
        var request = new XMLHttpRequest();
        var contentWrapper = document.getElementById('__eth-content');
        contentWrapper.style.opacity = 0;
        request.open('GET', Ethenis.getContentRealDir(), true);
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                contentWrapper.innerHTML = this.response;
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
        for(dir in __ETHENIS_CONFIG){
            if(path == dir || (dir.match(/\/.*\//) && path.match(dir)))
                realDir = "/content/" + __ETHENIS_CONFIG[dir][0];
        }
        return realDir;
    },
}


Ethenis.load();
