function capitalize(str) {
  const oneRegExp = /^[a-z]/;
  return str.replace(oneRegExp, function(s) {
    return s.toUpperCase();      
  });
}

capitalize('hello');
