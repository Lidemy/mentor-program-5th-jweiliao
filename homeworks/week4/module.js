const getBooks = (books) => {
  // let result = JSON.parse(res)
  let i = 0
  while (books[i]) {
    console.log(`${books[i].id} ${books[i].name}`)
    i++
  }
}

module.exports = {
  getBooks
}
