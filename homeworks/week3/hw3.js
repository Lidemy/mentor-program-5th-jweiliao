
const readline = require('readline')

const lines = []
const rl = readline.createInterface({
  input: process.stdin
})

rl.on('line', (line) => {
  lines.push(line)
})

function solve(lines) {
  const max = lines[0].split(' ')[0]
  let input = ''
  const arr = []
  for (let i = 1; i < lines.length; i++) {
    const tmp = lines[i].split(' ')
    input = Number(tmp[0])
    arr.push(input)
  }
  for (let j = 0; j < max; j++) {
    // eslint-disable-nextline
    isPrimeNumber(arr[j])
  }
  function isPrimeNumber(n) {
    if (n <= 1) return console.log('Composite')
    for (let j = 2; j * j <= n; j++) {
      if (n % j === 0) {
        return console.log('Composite')
      }
    }
    return console.log('Prime')
  }
}

rl.on('close', () => {
  solve(lines)
})
