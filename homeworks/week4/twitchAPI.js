// const process = require('process')
const axios = require('axios')

const url = 'https://api.twitch.tv/kraken/search/streams?query=Apex%20Legends&limit=100&offset=0'
const url2 = 'https://api.twitch.tv/kraken/search/streams?query=Apex%20Legends&limit=100&offset=100'
const clientID = 'q425xpddh26xjujtdplt1fl1ugjpn5'
const Accept = 'application/vnd.twitchtv.v5+json'
const config = {
  headers: {
    'Client-ID': clientID,
    Accept
  }
}

const callback = function() {
  axios.get(url2, config, callback)
    .then((response) => {
      const result = response.data.streams
      for (let i = 0; i <= result.length - 1; i++) {
        console.log(`${result[i].channel._id} ${result[i].channel.name}`)
      }
    }).catch((error) => {
      console.log(error)
    })
    .then(() => {})
}

axios.get(url, config, callback)
  .then((response) => {
    const result = response.data.streams
    for (let i = 0; i <= result.length - 1; i++) {
      console.log(`${result[i].channel._id} ${result[i].channel.name}`)
    }
    callback()
  })
  .catch((error) => {
    console.log(error)
  })
  .then(() => {})
