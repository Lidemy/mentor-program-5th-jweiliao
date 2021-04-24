function join(arr, concatStr) {
  if (arr.length > 1) {
    return arr.join(concatStr);
  }
  return Array.prototype.join.call(arguments, "");
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
