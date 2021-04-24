function reverse(str) {
  var arr = str.split("");
  reverseStr = "";
  var length = arr.length;
  for(var i=0;i<length;i++) {
    reverseStr += arr.pop();
  }
  console.log(reverseStr);
}

reverse('hello');
