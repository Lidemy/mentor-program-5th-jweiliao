const process = require('process')
const https = require('https')

const url = 'https://lidemy-book-store.herokuapp.com/books/'
// const config = { headers: { 'Content-Type': 'application/json'} }
const queryMethod = process.argv[2]
const argv3 = process.argv[3]
const argv4 = process.argv[4]

let params = {}
// eslint-disable-next-line
let messenger = ''

switch (queryMethod) {
  case 'list':
    params = {
      _limit: '20'
    }
    getList(params)
    break
  case 'read':
    params = argv3
    getBook(params)
    break
  case 'create':
    params = argv3
    addBook(params)
    break
  case 'delete':
    deleteBook(argv3)
    break
  case 'update':
    updateBook(argv3, argv4)
    break
  default:
    console.log('可輸入指令為 list read delete create update')
}

function getList(params) {
  https.get(`${url}?${params}`, (res) => {
    const data = []
    const headerDate = res.headers && res.headers.date ? res.headers.date : 'no response date'
    console.log('Date in Response header:', headerDate)

    if (res.statusCode >= 400 && res.statusCode < 500) {
      return console.log(`Status Code: ${res.statusCode}`)
    }
    if (res.statusCode >= 500) return console.log(`Status Code: ${res.statusCode}`)

    res.on('data', (chunk) => {
      data.push(chunk)
    })

    res.on('end', () => {
      const books = JSON.parse(Buffer.concat(data).toString())
      for (const book of books) {
        console.log(`${book.id} ${book.name}`)
      }
    })
  }).on('error', (err) => {
    console.log('Error: ', err.message)
  })
}

function getBook(params) {
  https.get(`${url}${params}`, (res) => {
    const data = []

    if (res.statusCode >= 400 && res.statusCode < 500) {
      return console.log(`Status Code: ${res.statusCode}`)
    }
    if (res.statusCode >= 500) return console.log(`Status Code: ${res.statusCode}`)

    res.on('data', (chunk) => {
      data.push(chunk)
    })

    res.on('end', () => {
      const book = JSON.parse(Buffer.concat(data).toString())
      console.log(`id: ${book.id} name: ${book.name}`)
    })
  }).on('error', (err) => {
    console.log('Error: ', err.message)
  })
}

function addBook(params) {
  const bookName = JSON.stringify({
    name: params
  })

  const options = {
    hostname: 'lidemy-book-store.herokuapp.com',
    port: '443',
    path: '/books',
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Content-Length': Buffer.byteLength(bookName)
    }
  }

  const req = https.request(options, (res) => {
    if (res.statusCode >= 400 && res.statusCode < 500) {
      return console.log(`Status Code: ${res.statusCode}`)
    }
    if (res.statusCode >= 500) return console.log(`Status Code: ${res.statusCode}`)

    res.on('data', (chunk) => {
      // process.stdout.write(chunk)
      console.log(`name: ${params} 新增成功`)
    })
  })

  req.on('error', (error) => {
    console.error(error)
  })

  req.write(bookName)
  req.end()
}

function deleteBook(params) {
  const options = {
    hostname: 'lidemy-book-store.herokuapp.com',
    port: '443',
    path: `/books/${params}`,
    method: 'DELETE'
  }

  const req = https.request(options, (res) => {
    if (res.statusCode >= 400 && res.statusCode < 500) {
      return console.log(`Status Code: ${res.statusCode}`)
    }
    if (res.statusCode >= 500) return console.log(`Status Code: ${res.statusCode}`)

    res.on('data', (chunk) => {
      console.log(`id: ${params} 刪除成功`)
    })
  })

  req.on('error', (error) => {
    console.error(error)
  })

  req.end()
}

function updateBook(params, message) {
  const bookName = JSON.stringify({
    name: message
  })
  const options = {
    hostname: 'lidemy-book-store.herokuapp.com',
    port: '443',
    path: `/books/${params}`,
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'Content-Length': Buffer.byteLength(bookName)
    }
  }

  const req = https.request(options, (res) => {
    if (res.statusCode >= 400 && res.statusCode < 500) {
      return console.log(`Status Code: ${res.statusCode}`)
    }
    if (res.statusCode >= 500) return console.log(`Status Code: ${res.statusCode}`)

    res.on('data', (chunk) => {
      console.log(`id: ${params} name: ${message} 更新成功`)
    })
  })

  req.on('error', (error) => {
    console.error(error)
  })

  req.write(bookName)
  req.end()
}
