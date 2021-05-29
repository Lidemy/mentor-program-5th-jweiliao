const process = require('process')
const request = require('request')

const baseUrl = 'https://api.twitch.tv/kraken'
const headers = {
  Accept: 'application/vnd.twitchtv.v5+json',
  'Client-ID': 'q425xpddh26xjujtdplt1fl1ugjpn5'
}
const limit = 100
const offset = 0
const total = 200
const game = process.argv[2]
const channels = []

function getAPI(game, offset, limit, total, channels) {
  request.get({
    baseUrl,
    uri: '/streams',
    headers,
    qs: {
      game,
      offset,
      limit
    }
  }, (err, res, body) => {
    let data

    if (err) {
      return console.err(`${err} 資料查詢失敗`)
    }

    if (res.statusCode >= 400 && res.statusCode < 500) {
      return console.log(`Status Code: ${res.statusCode}`)
    }
    if (res.statusCode >= 500) return console.log(`Status Code: ${res.statusCode}`)

    try {
      data = JSON.parse(body)
    } catch (err) {
      console.err(err)
    }

    const { streams } = data

    if (!streams.length) return console.log('查詢不到任何資料')

    for (const stream of streams) {
      const { channel } = stream
      channels.push([channel.display_name, channel._id])
    }
    console.log(channels.length)
    if (channels.length < total) {
      offset += limit
      return getAPI(game, offset, limit, total, channels)
    }

    channels = channels.slice(0, 200)

    for (const stream of channels) {
      const [name, id] = stream
      console.log(name, id)
    }
  })
}

getAPI(game, offset, limit, total, channels)
