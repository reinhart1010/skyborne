window.onload = function(){
  if (typeof CSS === 'undefined' || !CSS.supports('color', 'var(--fake-var)')){
    var newScript = document.createElement('script');
    newScript.type = 'text/javascript';
    newScript.src = 'https://cdn.jsdelivr.net/gh/nuxodin/ie11CustomProperties@4.1.0/ie11CustomProperties.min.js';
    document.getElementsByTagName('head')[0].appendChild(newScript);
  }
}