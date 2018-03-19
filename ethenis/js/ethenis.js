/* Using standard https://standardjs.com/ */
/* global __ETHENIS, history, location, XMLHttpRequest */

(function (ethenis, config) {
  'use strict'

  ;(function (history) {
    var pushState = history.pushState
    history.pushState = function () {
      pushState.apply(history, arguments)
      loadContent()
    }
  })(window.history)

  loadLinks(document.getElementsByClassName('__eth-link'))
  ethenis.loadLinks = loadLinks

  function loadLinks (elements) {
    if (elements != null) {
      forEachElement(elements, function (element) {
        element.addEventListener('click', function (event) {
          event.preventDefault()
          history.pushState('', '', element.getAttribute('href'))
        }, false)
      })
    }
  }

  var loadContent = (function () {
    var previousLocation = location.pathname
    return function () {
      if (previousLocation !== location.pathname) {
        scrollToTop(function () {
          document.getElementById('__eth-content').style.opacity = '0'
        })

        execOnPageChangeFunction()
        changeNavSelectedLink()
        document.body.classList.add('loading')

        var request = new XMLHttpRequest()
        var path = location.pathname +
          '?ajax=true&_=' + new Date().getTime()

        request.open('GET', path, true)
        request.onload = function () { requestOnload(request) }
        request.onerror = function () {
          console.error('Ethenis->loadContent()  Network Error')
        }
        request.onreadystatechange = function () {
          if (request.readyState === 4) {
            document.body.classList.remove('loading')
          }
        }
        request.send()
      }
      previousLocation = location.pathname
    }
  })()

  window.addEventListener('popstate', loadContent, true)

  function execOnPageChangeFunction () {
    if (typeof ethenis.onPageChange !== 'function') return
    ethenis.onPageChange()
    ethenis.onPageChange = null
  }

  function scrollToTop (callback) {
    var scrollDuration = config.scrollAnimationDuration // ms
    var scrollStep = window.scrollY / (scrollDuration / 15)
    if (scrollStep === 0) {
      window.scrollTo(0, 0)
      callback()
      return
    }

    var scrollInterval = setInterval(function () {
      if (window.scrollY > 0) { window.scrollBy(0, -scrollStep) } else {
        window.scrollTo(0, 0)
        clearInterval(scrollInterval)
        callback()
      }
    }, 15)
  }

  function changeNavSelectedLink () {
    var linkElements = document.getElementsByClassName('__eth-link')
    var actualDir = window.location.pathname.substring(1)
    forEachElement(linkElements, function (element) {
      element.classList.remove('__eth-selected-link')

      var elementDir = element.getAttribute('href').substring(1)
      if (elementDir === actualDir) {
        element.classList.add('__eth-selected-link')
      }
    })
  }

  function requestOnload (request) {
    var contentWrapper = document.getElementById('__eth-content')

    function showContent () {
      contentWrapper.removeEventListener('transitionend', showContent)

      contentWrapper.innerHTML = request.response
      contentWrapper.style.opacity = 1
      loadContentLinks()
      loadContentScripts()
    }

    if (request.status >= 200 && request.status <= 404) {
      var contentWrapperStyle = window.getComputedStyle(contentWrapper)
      if (contentWrapperStyle.getPropertyValue('opacity') === '0') {
        showContent()
      } else contentWrapper.addEventListener('transitionend', showContent)
    } else { console.error('Ethenis->loadContent()  Error: ' + this.status) }
  }

  function loadContentLinks () {
    var linkElements = document.querySelectorAll('#__eth-content .__eth-link')

    loadLinks(linkElements)
  }

  function loadContentScripts () {
    var scripts = document.getElementById('__eth-content')
      .getElementsByTagName('script')

    _loadContentScripts(scripts, 0)
  }

  function _loadContentScripts (scripts, i) {
    if (i >= scripts.length) return
    var actualScript = scripts[i]
    var script = document.createElement('script')

    if (actualScript.src) {
      var request = new XMLHttpRequest()
      request.open('GET', actualScript.src)
      request.onload = function () {
        script.textContent = request.response
        document.head.appendChild(script)
          .parentNode.removeChild(script)
        _loadContentScripts(scripts, ++i)
      }
      request.send()
    } else {
      script.textContent = actualScript.textContent
      document.head.appendChild(script)
        .parentNode.removeChild(script)
      _loadContentScripts(scripts, ++i)
    }
  }

  function forEachElement (elements, fn) {
    for (var i = 0; i < elements.length; i++) { fn(elements[i]) }
  }
})(__ETHENIS, __ETHENIS.config)
