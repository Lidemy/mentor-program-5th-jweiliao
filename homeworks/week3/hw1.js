
const readline = require('readline')

const lines = []
const rl = readline.createInterface({
  input: process.stdin
})

rl.on('line', (line) => {
  lines.push(line)
})

function solve(lines) {
  const n = lines[0]
  function printStars(n) {
    for (let i = 1; i <= n; i++) {
      let result = ''
      for (let j = 1; j <= i; j++) {
        result += '*'
      }
      console.log(result)
    }
  }

  printStars(n)
}

rl.on('close', () => {
  solve(lines)
})
