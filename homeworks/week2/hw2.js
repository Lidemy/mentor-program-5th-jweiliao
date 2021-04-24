function capitalize(str) {
  const oneRegExp = /^[a-zA-Z]/;
  return str.replace(oneRegExp, function(s) {
    return s.toUpperCase();      
  })
}

capitalize('hello');
