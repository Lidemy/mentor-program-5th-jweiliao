const axios = require('axios')
const process = require('process')

const cname = process.argv[2]

axios.get(`https://restcountries.eu/rest/v2/name/${cname}`)
  .then((response) => {
    const result = response.data[0]
    console.log(`
    ============
    國家 : ${result.name}
    首都 : ${result.capital}
    貨幣 : ${result.currencies[0].code}
    國碼 : ${result.callingCodes[0]}`)
  })
  .catch((error) => {
    console.log('找不到國家資訊')
  })
  .then(() => {})
