
var readline = require('readline');

var lines = []
var rl = readline.createInterface({
  input: process.stdin
});

rl.on('line', function (line) {
  lines.push(line)
});

rl.on('close', function() {
  solve(lines)
})

function solve(lines) {
  var fst = lines[0].split(' ')[0];
  var sec = lines[0].split(' ')[1];
  var arr = [];
  var brr = [];
  for(var i=1; i<lines.length; i++) {
    var tmp = lines[i].split(' ');
    var a = Number(tmp[0]);
    if(arr.length < fst) {
      arr.push(a);
    } else {
      brr.push(a);
    }
  }
  for(var i=0;i<sec;i++) {
    console.log(arr.indexOf(brr[i]));
  }
}