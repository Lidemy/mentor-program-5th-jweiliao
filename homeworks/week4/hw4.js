const axios = require('axios')

const url = 'https://api.twitch.tv/kraken/games/top'
const clientID = 'q425xpddh26xjujtdplt1fl1ugjpn5'
const Accept = 'application/vnd.twitchtv.v5+json'
const config = {
  headers: {
    'Client-ID': clientID,
    Accept
  }
}

axios.get(url, config)
  .then((response) => {
    const result = response.data.top
    for (const gameTop of result) {
      console.log(`${gameTop.viewers} ${gameTop.game.name}`)
    }
  })
  .catch((error) => {
    console.log(error)
  })
  .then(() => {})
