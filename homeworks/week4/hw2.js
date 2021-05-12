const process = require('process')
const axios = require('axios')
const mod = require('./module')

const url = 'https://lidemy-book-store.herokuapp.com/books/'
// const config = { headers: { 'Content-Type': 'application/json'} }
const queryMethod = process.argv[2]
const queryString = process.argv[3]
const queryMessenger = process.argv[4]

let params = {}
let messenger = ''

switch (queryMethod) {
  case 'list':
    params = {
      _limit: '20'
    }
    getAPI(params)
    break
  case 'read':
    params = {
      id: queryString
    }
    getAPI(params)
    break
  case 'create':
    params = {
      name: queryString
    }
    creatAPI(params)
    break
  case 'delete':
    deleteAPI(queryString)
    break
  case 'update':
    messenger = {
      name: queryMessenger
    }
    updateAPI(queryString, messenger)
    break
  default:
    console.log('可輸入指令為 list read delete create update')
}
// 查詢
function getAPI(params) {
  axios({
    method: 'get',
    url,
    params
  })
    .then((response) => {
      if (response.data.length !== 0) return mod.getBooks(response.data)
      console.log('查詢不到任何東西')
    })
    .catch((error) => {
      console.log(error)
      console.log(`error code: ${error.response.status} 查詢失敗`)
    })
    .then(() => {})
}
// 新增
function creatAPI(params) {
  axios.post(url, params)
    .then((response) => {
      console.log(`新增成功 ${response.data.id} ${response.data.name}`)
    })
    .catch((error) => {
      console.log(`error code: ${error.response.status} 新增失敗`)
    })
    .then(() => {})
}
// 刪除
function deleteAPI(params) {
  axios.delete(`${url}${params}`)
    .then((response) => {
      console.log('刪除成功')
    })
    .catch((error) => {
      console.log(`error code: ${error.response.status} 刪除失敗`)
    })
    .then(() => {})
}
// 更新
function updateAPI(params, messenger) {
  axios.patch(`${url}${params}`, messenger)
    .then((response) => {
      console.log(`更新成功 ${response.data.id} ${response.data.name}`)
    })
    .catch((error) => {
      console.log(`error code: ${error.response.status} 更新失敗`)
    })
    .then(() => {})
}
