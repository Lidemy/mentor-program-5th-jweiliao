// Twitch API KEY ¯\_(ツ)_/¯
const clientID = 'q425xpddh26xjujtdplt1fl1ugjpn5'
const Accept = 'application/vnd.twitchtv.v5+json'
const offset = 0

function getTopGameAPI() {
  const url = 'https://api.twitch.tv/kraken/games/top'
  const config = {
    headers: {
      'Client-ID': clientID,
      Accept
    }
  }
  // eslint-disable-next-line
  axios.get(url, config)
    .then((response) => {
      const topGames = response.data.top
      const gameList = []
      for (const topGame of topGames) {
        gameList.push(topGame.game.name)
      }
      generateNav(gameList)
    })
    .catch((error) => {
      console.log(error)
    })
    .then(() => {})
}
function getStreamsAPI(topGame, offset) {
  const game = (!topGame) ? '' : topGame

  const limit = 20
  const channels = []

  const url = 'https://api.twitch.tv/kraken/streams/'
  const config = {
    headers: {
      'Client-ID': clientID,
      Accept
    },
    params: {
      game,
      offset,
      limit
    }
  }
  // get Twitch top 20 games
  // eslint-disable-next-line
  axios.get(url, config)
    .then((response) => {
      const { streams } = response.data
      // const { result } = response

      // console.log(response.data)
      // console.log(streams.length, offset, limit, game)
      if (!streams.length) return console.log('查詢不到任何資料')
      // 假如取得的資料少於 limit 就在抓一次
      if (streams.length < limit) {
        // console.log('streams.length', streams.length)
        // console.log('offset', offset)
        return getStreamsAPI(game, offset + 1)
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
    })
    .catch((error) => {
      console.log(error)
    })
    .then(() => {})
}

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

  getStreamsAPI(topGame, offset)
}

// init
getTopGameAPI()
getStreamsAPI(null, offset)

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

// fade effect
// function fadeOut(element) {
//   var opacity = 0;
//   function decrease () {
//     opacity += 0.05
//     if (opacity >= 0){
//         // complete
//         element.style.opacity = 1;
//         return true
//     }
//     element.style.opacity = opacity
//     requestAnimationFrame(decrease)
//   }
//   decrease()
// }
// fadeOut()

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
  getStreamsAPI(topGame, offset)
})

// function scrollTo() {
//   let scrollHeight = Math.max(
//     document.body.scrollHeight, document.documentElement.scrollHeight,
//     document.body.offsetHeight, document.documentElement.offsetHeight,
//     document.body.clientHeight, document.documentElement.clientHeight
//   )
//   console.log(scrollHeight)
// }
// const resizeObserver = new ResizeObserver(entries => {
//   const contentHeight =  document.querySelector('.content').offsetHeight
//   console.log('Body height changed:', entries[0].target.clientHeight)
// })
// window.setTimeout((contentHeight) => {
//   window.scrollTo(0, contentHeight)
//   resizeObserver.disconnect()
// }, 1000)
// resizeObserver.observe(document.body)

// loading frame
// function loading() {
//   content = document.querySelector('.content')
//   loader = document.createElement('DIV')
//   loader.classList = 'loaderFrame'
//   content.appendChild(loader)
// }
// function clear() {
//   let loader =document.querySelector('.loader')
//   loader.parentNode.removeChild(loader)
// }
// loading()
