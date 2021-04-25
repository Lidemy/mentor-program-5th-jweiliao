function add(x, y) {
  while(y != 0) {
    var carry = x & y;
    x ^= y;
    y = carry << 1;
  }
  return x
}

console.log(add(20, 2));