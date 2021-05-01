
const readline = require('readline')

const lines = []
const rl = readline.createInterface({
  input: process.stdin
})

rl.on('line', (line) => {
  lines.push(line)
})

function solve(lines) {
  const max = lines[0]

  for (let i = 1; i <= max; i++) {
    const [a, b, k] = lines[i].split(' ')
    console.log(compareNumbers(a, b, k))
  }
  function compareNumbers(a, b, k) {
    if (a === b) return 'DRAW'
    if (Number(k) === -1) b = [a, a = b][0] // eslint-disable-line
    if (a.length > b.length) return 'A'
    if (a.length < b.length) return 'B'
    if (a.length === b.length) {
      for (let j = 0; j < a.length; j++) {
        if (a[j] === b[j]) continue
        if (a[j] > b[j]) {
          return 'A'
        } else {
          return 'B'
        }
      }
    }
  }
}

rl.on('close', () => {
  solve(lines)
})
