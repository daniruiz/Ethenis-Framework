'use strict'

;((ethenis, config) => {
  ;(history => {
    let pushState = history.pushState
    history.pushState = function () {
      pushState.apply(history, arguments)
      loadContent()
    }
  })(window.history)

  function loadLinks (elements) {
    if (elements instanceof HTMLElement) elements = [elements]
    let numElements = elements !== undefined ? (elements.length !== undefined ? elements.length : 0) : 0
    for (let i = 0; i < numElements; i++) {
      let element = (elements[i] || elements)
      element.addEventListener('click', event => {
        event.preventDefault()
        history.pushState('', '', element.getAttribute('href'))
      }, false)
    }
  }

  let loadContent = (() => {
    let previousLocation = location.pathname
    return function (reload = false) {
      if (previousLocation !== location.pathname || reload) {
        scrollToTop(() => {
          document.getElementById('__eth-content').style.opacity = '0'
          setTimeout(() => {
            document.getElementById('__eth-content').dispatchEvent(new Event('fadetransitionend'))
          }, config.fadeAnimationDuration)
        })

        execOnPageChangeFunction()
        changeNavSelectedLink()
        document.body.classList.add('loading')

        let request = new XMLHttpRequest()
        let path = location.pathname +
          '?ajax=true&_=' + new Date().getTime()

        request.open('GET', path, true)
        request.onload = () => { requestOnload(request) }
        request.onerror = () => {
          console.error('Ethenis->loadContent()  Network Error')
        }
        request.onreadystatechange = () => {
          if (request.readyState === 4) {
            document.body.classList.remove('loading')
          }
        }
        request.send()
      }
      previousLocation = location.pathname
    }
  })()

  function reloadContent () {
    loadContent(true)
  }

  function scrollToTop (fnc) {
    if (isNaN(config.scrollAnimationDuration) || config.scrollAnimationDuration <= 0) {
      window.scrollTo(0, 0)
      fnc()
      return
    }

    let minStep = 0.01
    let scrollStep = Math.max(window.scrollY / (config.scrollAnimationDuration / 15), minStep)

    let scrollInterval = setInterval(() => {
      if (window.scrollY > 0) window.scrollBy(0, -scrollStep)
      else {
        clearInterval(scrollInterval)
        fnc()
      }
    }, 15)
  }

  function changeNavSelectedLink () {
    let linkElements = document.getElementsByClassName('__eth-link')
    let actualDir = window.location.pathname.substring(1)
    ;[].forEach.call(linkElements, element => {
      element.classList.remove('__eth-selected-link')

      let elementDir = element.getAttribute('href').substring(1)
      if (elementDir === actualDir) {
        element.classList.add('__eth-selected-link')
      }
    })
  }

  function requestOnload (request) {
    let contentWrapper = document.getElementById('__eth-content')

    function showContent () {
      contentWrapper.removeEventListener('fadetransitionend', showContent, false)

      contentWrapper.innerHTML = request.response
      contentWrapper.style.opacity = 1
      loadContentScripts()
      loadContentLinks()
      execOnLoad()
    }

    if (request.status >= 200 && request.status <= 404) {
      let contentWrapperStyle = window.getComputedStyle(contentWrapper)
      if (contentWrapperStyle.getPropertyValue('opacity') === '0') {
        showContent()
      } else contentWrapper.addEventListener('fadetransitionend', showContent, false)
    } else { console.error('Ethenis->loadContent()  Error: ' + request.status) }
  }

  function execOnPageChangeFunction () {
    if (typeof ethenis.onPageChange === 'function') ethenis.onPageChange()
    ethenis.onPageChange = null
  }

  function execOnLoad () {
    if (typeof ethenis.onLoad === 'function') ethenis.onLoad()
    if (typeof ethenis.onLoadOnce === 'function') {
      ethenis.onLoadOnce()
      ethenis.onLoadOnce = null
    }
  }

  function loadContentLinks () {
    let linkElements = document.querySelectorAll('#__eth-content .__eth-link')

    loadLinks(linkElements)
  }

  function loadContentScripts () {
    let scripts = document.getElementById('__eth-content')
      .getElementsByTagName('script')

    _loadContentScripts(scripts, 0)
  }

  function _loadContentScripts (scripts, i) {
    if (i >= scripts.length) return
    let actualScript = scripts[i]
    let script = document.createElement('script')

    if (actualScript.src) {
      let request = new XMLHttpRequest()
      request.open('GET', actualScript.src)
      request.onload = () => {
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

  loadLinks(document.getElementsByClassName('__eth-link'))
  ethenis.loadLinks = loadLinks
  ethenis.reloadContent = reloadContent
  if ('scrollRestoration' in history) history.scrollRestoration = 'manual'
  execOnLoad()
  window.addEventListener('popstate', loadContent, true)

})(__ETHENIS, __ETHENIS.config)
