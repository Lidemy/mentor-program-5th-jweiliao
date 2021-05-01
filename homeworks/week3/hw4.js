
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
  const str = tmp[0]
  function isPalindrome(str) {
    const arr = str.split('')
    return (arr.join('') === arr.reverse().join('')) ? 'True' : 'False'
  }
  console.log(isPalindrome(str))
}

rl.on('close', () => {
  solve(lines)
})
