// Twitch API KEY ¯\_(ツ)_/¯
const clientID = 'q425xpddh26xjujtdplt1fl1ugjpn5'
const Accept = 'application/vnd.twitchtv.v5+json'
const offset = 0
const limit = 20

function getTopGameAPI() {
  const xhr = new XMLHttpRequest()
  const params = '?limit=5'
  // eslint-disable-next-line
  xhr.open('GET', 'https://api.twitch.tv/kraken/games/top' + params, true)
  xhr.setRequestHeader('Client-ID', clientID)
  xhr.setRequestHeader('Accept', Accept)
  xhr.send(null)

  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const result = JSON.parse(xhr.responseText)
      const topGames = result.top
      const gameList = []
      for (const topGame of topGames) {
        gameList.push(topGame.game.name)
      }
      generateNav(gameList)
    }
  }
  xhr.onload = function(data) {
    // console.log(xhr.responseText)
  }
}
function getStreamsAPI(topGame, offset, limit) {
  const game = (!topGame) ? '' : topGame
  const channels = []
  const url = 'https://api.twitch.tv/kraken/streams/'

  const xhr = new XMLHttpRequest()
  const params = `?game=${game}&offset=${offset}&limit=${limit}`

  xhr.open('GET', url + params, true)
  xhr.setRequestHeader('Client-ID', clientID)
  xhr.setRequestHeader('Accept', Accept)
  xhr.send(null)
  xhr.onreadystatechange = () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const result = JSON.parse(xhr.responseText)
      const { streams } = result
      const loadBtn = document.getElementById('load-more')

      if (streams.length === 0) {
        loadBtn.style.display = 'none'
        return
      }
      if (streams.length < limit) {
        loadBtn.style.display = 'none'
        return
      } else {
        loadBtn.style.display = 'block'
      }

      for (const stream of streams) {
        const { channel } = stream
        const { preview } = stream
        // eslint-disable-next-line
        const { stream_type } = stream

        channels.push([
          preview,
          // eslint-disable-next-line
          stream_type,
          channel.status,
          channel.display_name,
          channel.game,
          // channel.name,
          // channel._id,
          channel.logo,
          channel.language,
          // channel.profile_banner,
          // channel.video_banner,
          channel.url
          // channel.views
        ])
      }
      console.log(channels)

      // 實作

      for (const stream of channels) {
        generateHTML(stream)
      }
      // eslint-disable-next-line
      function generateHTML(result) {
        const content = document.querySelector('.content')
        const templateHTML = document.createElement('DIV')
        const loadBtn = document.getElementById('load-more')
        const [
          preview,
          streamType,
          status,
          displayName,
          game,
          // name,
          // id,
          logo,
          language,
          // profile_banner,
          // video_banner,
          url
          // views
        ] = result

        // 這裡也可以<img> 也可以下 loading="lazy"，Chrome 有實作此功能
        templateHTML.innerHTML = `<a href="${url}" target="_blank">
          <img data-src="${preview.large}" class="lazyload">
          <div class="card-row">
            <div class="card-logo"><img data-src="${logo}" class="lazyload"></div> 
            <div class="card-info">
              <h3>${status}</h3>
              <p>${displayName}</p>
              <h5>${game}</h5>
              <span class="tag">語言: ${language}</span>
              <span class="stream-type">${streamType}</span>
            </div>
          </div>
        </a>`
        templateHTML.classList = 'pure-u-xl-1-5 pure-u-lg-1-4 pure-u-md-1-3 pure-u-sm-1-2 card-views'
        content.appendChild(templateHTML)

        loadBtn.textContent = '載入更多'
        loadBtn.disabled = false
      }
    }
    // xhr.onload = function(data) {
    //   console.log(xhr.responseText)
    // }
  }
}
// eslint-disable-next-line
function generateNav(gameList) {
  const topNav = document.getElementsByClassName('twitch-top-game')[0]

  for (let i = 0; i < topNav.children.length; i++) {
    topNav.children[i].id = `twitch-top-${i + 1}`
    // eslint-disable-next-line
    topNav.children[i].setAttribute('onclick', 'generateChannels(this, "' + gameList[i] + '")')
    // topNav.children[i].setAttribute('onclick', `generateChannels(this, ${gameList[i]})`)
    topNav.children[i].textContent = gameList[i]
  }
}
// eslint-disable-next-line
function generateChannels(e, topGame) {
  const element = document.getElementsByClassName('content')[0]

  while (element.firstChild) {
    element.removeChild(element.firstChild)
  }

  const getSiblings = (e) => {
    const siblings = []

    if (!e.parentNode) {
      return siblings
    }

    let sibling = e.parentNode.firstChild

    while (sibling) {
      if (sibling.nodeType === 1 && sibling !== e) {
        siblings.push(sibling)
      }
      sibling = sibling.nextSibling
    }

    for (let i = 0; i < siblings.length; i++) {
      siblings[i].classList.remove('active')
    }
    e.classList.add('active')

    // return siblings
  }

  getSiblings(e)

  getStreamsAPI(topGame, offset, limit)
}

// init
getTopGameAPI()
getStreamsAPI(null, offset, limit)

// header effect
function headerScroll() {
  // eslint-disable-next-line
  const body = document.body
  // const header = document.querySelector('.header')
  const scrollUp = 'scroll-up'
  const scrollDown = 'scroll-down'
  let lastScroll = 0
  // window.scrollTo(0,document.querySelector('.content').scrollHeight)
  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset

    if (currentScroll <= 0) {
      body.classList.remove(scrollUp)
      return
    }

    if (currentScroll > lastScroll && !body.classList.contains(scrollDown)) {
      body.classList.remove(scrollUp)
      body.classList.add(scrollDown)
    } else if (currentScroll < lastScroll && body.classList.contains(scrollDown)) {
      body.classList.remove(scrollDown)
      body.classList.add(scrollUp)
    }
    lastScroll = currentScroll
  })
}
// menu
function menu() {
  const menu = document.querySelector('.menu')
  const nav = document.querySelector('.navgation')
  // const topGame = nav.children[0]

  // menu
  menu.addEventListener('click', () => {
    menu.classList.toggle('open')
    nav.classList.toggle('open')
  })
}

menu()
headerScroll()

// infinite scroll
// document.addEventListener('DOMContentLoaded', () => {
//   let options = {
//     root: null,
//     rootMargins: '0px',
//     threshold: 0.5
//   };
//   const observer = new IntersectionObserver(handleIntersect, options);
//   observer.observe(document.querySelector('footer'))
//   // getData();
// })
// function handleIntersect(entries) {
//   if (entries[0].isIntersecting) {
//     getData()
//   }
// }
// function getData() {
//   const loadBtn = document.getElementById('load-more')
//   let topGame = document.querySelector('.twitch-top-game > li.active') || ''
//   let offset = document.getElementsByClassName('card-views').length

//   if (topGame) {
//     topGame = topGame.textContent
//   }

//   loadBtn.textContent = '載入中...'
//   loadBtn.disabled = true
//   getStreamsAPI(topGame, offset)
// }

const loadMore = document.getElementById('load-more')
loadMore.addEventListener('click', () => {
  let topGame = document.querySelector('.twitch-top-game > li.active') || ''
  const offset = document.getElementsByClassName('card-views').length
  const loadBtn = document.getElementById('load-more')

  if (topGame) {
    topGame = topGame.textContent
  }

  loadBtn.textContent = '載入中...'
  loadBtn.disabled = true
  getStreamsAPI(topGame, offset, limit)
})
