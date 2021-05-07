// eslint-disable-next-line
const XMLHttpRequest = require('xmlhttprequest').XMLHttpRequest
const axios = require('axios')

const xhr = new XMLHttpRequest()
xhr.open('GET', 'https://lidemy-book-store.herokuapp.com/books?_limit=10', true)
xhr.send(null)
// eslint-disable-next-line
xhr.onreadystatechange = function () {
  if (xhr.readyState === 4 && xhr.status === 200) {
    const result = JSON.parse(xhr.responseText)
    let i = 0
    while (result[i]) {
      // console.log(`${result[i].id} ${result[i].name}`)
      i++
    }
  }
}
// xhr.onload = function(data) {
//   console.log(xhr.responseText);
// }

axios.get('https://lidemy-book-store.herokuapp.com/books?_limit=10')
  .then((response) => {
    // handle success
    const result = JSON.parse(xhr.responseText)
    let i = 0
    while (result[i]) {
      console.log(`${result[i].id} ${result[i].name}`)
      i++
    }
  })
  .catch((error) => {
    console.log(error)
  })
  .then(() => {})
