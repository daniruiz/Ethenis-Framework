/* eslint-disable curly */

'use strict'

;(function (ethenis, config) {
  const $ = query => document.querySelector(query)
  const $$ = query => document.querySelectorAll(query)
  const load = path => {
    document.body.classList.add('loading')
    return fetch(path).then(response => {
      document.body.classList.remove('loading')
      return response.text()
    })
  }

  Object.assign(ethenis, {
    onLoad: ethenis.onLoad,
    onLoadOnce: ethenis.onLoadOnce,
    onPageChange: ethenis.onPageChange,

    reloadContent: () => { ethenis._loadContent(true) },

    loadPage: path => {
        history.pushState('', '', path)
        history.replaceState('', '', location.pathname.replace(/\/+$/, ''))
        ethenis._loadContent()
    },

    loadLinks: elements => {
      if (elements instanceof HTMLElement)
        elements = [elements]

      ;[...elements].forEach(element => {
        element.addEventListener('click', event => {
          event.preventDefault()
          ethenis.loadPage(element.getAttribute('href'))
        })
      })
    },

    _start: () => {
      if ('scrollRestoration' in history)
        history.scrollRestoration = 'manual'

      window.addEventListener('popstate', () => { ethenis._loadContent(false) })
      ethenis.loadLinks($$('.__eth-link'))
      ethenis._execOnLoad()
    },

    _loadContent: (() => {
      const changeNavSelectedLink = () => {
        const actualDir = location.pathname.substring(1)
        $$('.__eth-link').forEach(element => {
          element.classList.remove('__eth-selected-link')
          const elementDir = element.getAttribute('href').substring(1)
          if (elementDir === actualDir) {
            element.classList.add('__eth-selected-link')
          }
        })
      }

      const animatePageChange = () => new Promise(resolve => {
        const scrollToTop = () => new Promise(resolve => {
          const ms = 1000 / 60
          const scrollStep =
            Math.ceil(window.scrollY / config.scrollAnimationDuration * ms)
          const scrollInterval = setInterval(() => {
            if (window.scrollY > 0) {
              window.scrollBy(0, -scrollStep)
            } else {
              clearInterval(scrollInterval)
              resolve()
            }
          }, ms)
        })

        const endAnimation = () => {
          $('#__eth-content').style.opacity = 1
        }

        scrollToTop().then(() => {
          $('#__eth-content').style.opacity = 0
          setTimeout(resolve, config.fadeAnimationDuration, endAnimation)
        })
      })

      const loadContentLinks = () => {
        ethenis.loadLinks($$('#__eth-content .__eth-link'))
      }

      const loadContentScripts = () => {
        return Promise.all([...$$('#__eth-content script')].map(scriptElement =>
          scriptElement.src
            ? load(scriptElement.src)
            : scriptElement.textContent
        )).then(([...scripts]) => {
          scripts.forEach(textContent => {
            const scriptElement =
              Object.assign(document.createElement('SCRIPT'), { textContent })
            document.head
              .appendChild(scriptElement)
              .parentNode.removeChild(scriptElement)
          })
        })
      }

      let previousLocation = location.pathname

      return (reload = false) => {
        if (previousLocation === location.pathname && reload === false)
          return

        previousLocation = location.pathname
        ethenis._execOnPageChange()
        changeNavSelectedLink()
        const animationPromise = animatePageChange()
        const fetchPromise =
          load(location.pathname + '?ajax=true&_=' + new Date().getTime())
        Promise.all([fetchPromise, animationPromise])
          .then(([html, animationCallback]) => {
            $('#__eth-content').innerHTML = html
            loadContentLinks()
            loadContentScripts()
              .then(ethenis._execOnLoad)
            animationCallback()
          })
      }
    })(),

    _execOnLoad: () => {
      if (typeof ethenis.onLoad === 'function')
        ethenis.onLoad()
      if (typeof ethenis.onLoadOnce === 'function')
        ethenis.onLoadOnce()
      ethenis.onLoadOnce = null
    },

    _execOnPageChange: () => {
      if (typeof ethenis.onPageChange === 'function')
        ethenis.onPageChange()
      ethenis.onPageChange = null
    }
  })

  ethenis._start()
})(__ETHENIS, __ETHENIS.config)
