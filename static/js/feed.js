
var myPrettyCode = function() {
    hljs.configure({useBR: true});

    document.querySelectorAll('.xml').forEach((block) => {
      console.log(block);
      hljs.highlightBlock(block);
    });
};
loadStyle(baseurl + "static/css/highlight.min.css");
loadScript(baseurl + "static/js/highlight.min.js", myPrettyCode);