function multiply(a,b) {
  var res = Array(a.length + b.length).fill(0);
  var p;
  for(var j = b.length - 1; j >= 0; j--) {
  	var c = 0;
    var k = a.length + j;
    for (var i = a.length - 1 ; i >= 0; i--) {
			p = a[i] * b[j] + c + res[k];
      res[k] = p % 10;
      c = (p - res[k]) / 10;
      k--;
    }
    res[k] += c;
  }
  return res.join('').replace(/^0+(.)/, '$1');
}

console.log(multiply("8","10"));
console.log(multiply("80","10"));
console.log(multiply("808","10"));