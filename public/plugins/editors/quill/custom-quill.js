// Basic

var quill = new Quill('#descrizioneEditor', {
  modules: {
    toolbar: [
      [{ header: [1, 2, 3, 4, 5, 6,  false] }],
      ['bold', 'italic', 'underline','strike'],
      ['image', 'code-block'],
      ['link'],
      [{ 'script': 'sub'}, { 'script': 'super' }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['clean']
    ]
  },
  placeholder: 'Inserisci una descrizione',
  theme: 'snow'  // or 'bubble'
});

quill.on('text-change', function(delta, source) {
	updateHtmlOutput()
})

function getQuillHtml() { return quill.root.innerHTML; }

//function updateHighlight() { hljs.highlightBlock( document.querySelector('#descrizione') ) }

function updateHtmlOutput()
{
	let html = getQuillHtml();
    console.log ( html );
    document.getElementById('descrizione').value = html;
    //updateHighlight();
}


updateHtmlOutput()

// With Tooltip
/*

  var quill = new Quill('#quill-tooltip', {
    modules: {
      toolbar: '#toolbar-container'
    },
    placeholder: 'Compose an epic...',
    theme: 'snow'
  });
  
  // Enable all tooltips
  $('[data-toggle="tooltip"]').tooltip();
  
  // Can control programmatically too
  $('.ql-italic').mouseover();
  setTimeout(function() {
    $('.ql-italic').mouseout();
  }, 2500);*/