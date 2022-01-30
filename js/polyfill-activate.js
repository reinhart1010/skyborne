window.onload = function(){
  if (typeof CSS === 'undefined' || !CSS.supports('color', 'var(--fake-var)')){
    document.write('<script src="https://cdn.jsdelivr.net/gh/nuxodin/ie11CustomProperties@4.1.0/ie11CustomProperties.min.js"><\/script>')
  }
}