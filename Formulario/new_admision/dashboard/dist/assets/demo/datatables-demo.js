// Call the dataTables jQuery plugin
$(document).ready(function() {
 /* 
  $.fn.dataTable.ext.type.order['html-pre'] = function ( a ) {
    return !a ?
        '' :
        a.replace ?
            $.trim( a.replace( /<.*?>/g, "" ).toLowerCase() ) :
            a+'';
  };
*/
  $('#dataTable').DataTable({
    language: {
      url: '../../js/es-mx.json'
  }
  });

});
