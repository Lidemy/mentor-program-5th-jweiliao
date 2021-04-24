function join(arr, concatStr) {
  var str = "";
  for(var i=0;i<arr.length;i++) {
    str += arr[i];
    if(i === 0 || i < arr.length - 1) str += concatStr;
  }
  return str
}

function repeat(str, times) {
  var repeatStr = "";  
  for(var i=0;i<times;i++) {
    repeatStr += str;
  }
  return repeatStr;
}

console.log(join(['a'], '!'));
console.log(repeat('a', 5));
