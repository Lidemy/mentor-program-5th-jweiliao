function reverse(str) {
  var arr = [],
      reverseStr = "";
  arr = str.split("");
  while(arr.length > 0) {
    reverseStr += arr.slice(arr.length-1);
    arr.length--
  }
  console.log(reverseStr);
}

reverse('hello');
