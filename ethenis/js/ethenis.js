(function (config) {
  'use strict';

  (function () {
    var linkElements = document.getElementsByClassName('__eth-link')
    loadLinks(linkElements)

    window.addEventListener('popstate', loadContent)
  })()

  function loadLinks (elements) {
    if (elements != null) {
      forEachElement(elements, function (element) {
        element.onclick = function (event) {
          event.preventDefault()

          history.pushState('', '', element.getAttribute('href'))
          loadContent()
        }
      })
    }
  }

  function loadContent () {
    scrollToTop(function () {
      document.getElementById('__eth-content').style.opacity = 0
    })

    execOnPageChangeFunction()
    changeNavSelectedLink()

    var request = new XMLHttpRequest()
    var path = window.location.pathname +
        '?ajax=true&_=' + new Date().getTime()

    request.open('GET', path, true)
    request.onload = function () { requestOnload(request) }
    request.onerror = function () {
      console.log('Ethenis->loadContent()  FatalError')
    }
    request.send()
  }

  function execOnPageChangeFunction () {
    if (typeof Ethenis.onPageChange === 'function') {
      Ethenis.onPageChange()
      Ethenis.onPageChange = function () {}
    }
  }

  function scrollToTop (callback) {
    var scrollDuration = config.scrollAnimationDuration // ms
    var scrollStep = window.scrollY / (scrollDuration / 15)
    if (scrollStep == 0) {
      window.scrollTo(0, 0)
      callback()
      return
    }

    disableScroll()
    var scrollInterval =
        setInterval(function () {
          if (window.scrollY != 0) { window.scrollBy(0, -scrollStep) } else {
            clearInterval(scrollInterval)
            callback()
            enableScroll()
          }
        }, 15)
  }

  function disableScroll () {
    window.addEventListener('wheel', _preventDefault)
    window.addEventListener('ontouchmove', _preventDefault)
    window.addEventListener('keydown', _preventDefaultForScrollKeys)
  }

  function enableScroll () {
    window.removeEventListener('wheel', _preventDefault)
    window.removeEventListener('ontouchmove', _preventDefault)
    window.removeEventListener('keydown', _preventDefaultForScrollKeys)
  }

  function _preventDefault (e) {
    e = e || window.event
    if (e.preventDefault) { e.preventDefault() }
    e.returnValue = false
  }

  function _preventDefaultForScrollKeys (e) {
    var arrowKeys = { 37: 1, 38: 1, 39: 1, 40: 1 }
    if (arrowKeys[e.keyCode]) {
      _preventDefault(e)
      return false
    }
  }

  function changeNavSelectedLink () {
    var linkElements = document.getElementsByClassName('__eth-link')
    var actualDir = window.location.pathname.substring(1)
    forEachElement(linkElements, function (element) {
      element.classList.remove('__eth-selected-link')

      var elementDir = element.getAttribute('href').substring(1)
      if (elementDir == actualDir) {
        element.classList.add('__eth-selected-link')
      }
    })
  }

  function requestOnload (request) {
    var contentWrapper = document.getElementById('__eth-content')

    if (request.status >= 200 && request.status < 400) {
      var contentWrapperStyle = window.getComputedStyle(contentWrapper)
      if (contentWrapperStyle.getPropertyValue('opacity') == 0) {
        showContent()
      } else contentWrapper.addEventListener('transitionend', showContent)

      function showContent () {
        contentWrapper.removeEventListener('transitionend', showContent)

        contentWrapper.innerHTML = request.response
        contentWrapper.style.opacity = 1
        loadContentLinks()
        loadContentScripts()
      }
    } else { console.log('Ethenis->loadContent()  Error: ' + this.status) }
  }

  function loadContentLinks () {
    var linkElements = document.querySelectorAll('#__eth-content .__eth-link')

    loadLinks(linkElements)
  }

  function loadContentScripts () {
    var scripts = document.getElementById('__eth-content')
        .getElementsByTagName('script')

    forEachElement(scripts, function (s) {
      var script = document.createElement('script')

      if (s.src) {
        script.src = s.src
      } else { script.textContent = s.innerText }

      document.head.appendChild(script)
        .parentNode.removeChild(script)
    })
  }

  function forEachElement (elements, fn) {
    for (var i = 0; i < elements.length; i++) { fn(elements[i]) }
  }
})(__ETHENIS_CONFIG)
