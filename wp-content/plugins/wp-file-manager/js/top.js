var $ = jQuery;
function fm_get_network_url(){
  var urlhash = window.location.hash;
  var href = '';
  if(urlhash){
    var arr = urlhash.split('_');
    var lastItem = arr.pop();
    var txt = decodeURIComponent(escape(window.atob(lastItem)));

    if(fmfparams.is_multisite == '1')
    {
      if(txt == '/')
      {
        href = fmfparams.network_url;
      }
    }
  }
  return href;
}