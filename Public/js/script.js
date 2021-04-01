window.onload = () => {

  let boutons = document.querySelectorAll( ".custom-control-input" )

  for( let bouton of boutons ) {
    bouton.addEventListener( 'click', activer )
  }

}

function activer() {


  let xmlhttp = new XMLHttpRequest;
  
  xmlhttp.open( 'GET', '/mvc6/admin/activeArticle/' + this.dataset.id )

  xmlhttp.send();

}