
const readline = require('readline')

const lines = []
const rl = readline.createInterface({
  input: process.stdin
})

rl.on('line', (line) => {
  lines.push(line)
})

function solve(lines) {
  const tmp = lines[0].split(' ')
  const min = Number(tmp[0])
  const max = Number(tmp[1])
  function isNarcissistic(min, max) {
    for (let i = min; i <= max; i++) {
      const isNarcissistic = calcNarcissistic(i)
      if (i === isNarcissistic) console.log(isNarcissistic)
    }
  }
  function calcNarcissistic(max) {
    const arr = max.toString(10).split('')
    const square = arr.length
    let sum = 0
    /* eslint-disable */
    const result = arr.reduce(function(max, n) {
      return sum += n ** square
    }, 0)
    return result
    /* eslint-disable */
  }
  isNarcissistic(min, max)
}

rl.on('close', () => {
  solve(lines)
})
